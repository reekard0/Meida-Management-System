<!doctype html>
<html>
<head>
<title>Media List</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f2f2f2;
    }
    h1 {
        text-align: center;
        color: #d35400;
    }
    .search-container {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .search-container input[type=text],
    .search-container select {
        margin-right: 10px;
        border: 1px solid #d35400;
        border-radius: 3px;
        padding: 5px;
    }
    .search-container button {
        background-color: #d35400;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        cursor: pointer;
    }
    .search-container button:hover {
        background-color: #b03a00;
    }
    .media-item {
        display: flex;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,.1);
        padding: 10px;
    }
    .media-item-image {
    flex: 0 0 200px;
    margin-right: 10px;
    }
    .media-item-image audio,
    .media-item-image img,
    .media-item-image video {
        max-width: 500px; /* Adjust the max-width value to your desired width */
        max-height: 500px; /* Adjust the max-height value to your desired height */
    }
    .media-item-details {
        flex-grow: 1;
    }
    .media-item-details h3 {
        margin-top: 0;
        color: #d35400;
    }
    .media-item-details p {
        margin-bottom: 5px;
    }
    .media-item-actions {
        flex: 0 0 50px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .media-item-actions button {
        margin-bottom: 10px;
        background-color: #d35400;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 5px 10px;
        cursor: pointer;
    }
    .media-item-actions button:hover {
        background-color: #b03a00;
    }
    .media-item-caption {
        margin-top: 10px;
    }
</style>
</head>
<body>
<h1>Media List</h1>
<center>
<p> <a href="/" style="color: blue;">Main Menu</a> </p>
<p> <a href="/" style="color: blue;">Upload</a> </p>
<p> <a href="/logout" style="color: blue;">Logout</a> </p>
</center>
<div class="search-container">
    <input id="search-input" placeholder="Search">
    <select id="search-category">
        <option value="all">All</option>
        <option value="filename">Filename</option>
        <option value="id">ID</option>
        <option value="caption">Caption</option>
    </select>
    <select id="search-filter">
        <option value="all">All</option>
        <option value="image">Image</option>
        <option value="video">Video</option>
        <option value="audio">Audio</option>
    </select>
    <button type="button" id="search-button">Search</button>
</div>
<center>
<button id="randomize-button">I'm feeling lucky</button>
</center>
<p></p>
<div class="media-list">
        <?php foreach ($media as $item): ?>
            <?php
                $extension = pathinfo($item['url'], PATHINFO_EXTENSION);
                $mediatype = '';
                if (strpos($extension, 'jpg') !== false || strpos($extension, 'jpeg') !== false || strpos($extension, 'png') !== false || strpos($extension, 'gif') !== false || strpos($extension, 'webp') !== false) {
                    $mediatype = 'Image';
                } elseif (strpos($extension, 'mp4') !== false || strpos($extension, 'mov') !== false || strpos($extension, 'avi') !== false) {
                    $mediatype = 'Video';
                } elseif (strpos($extension, 'mp3') !== false || strpos($extension, 'wav') !== false) {
                    $mediatype = 'Audio';
                }
            ?>
            <div class="media-item">
              <div class="media-item-image">
                  <?php if ($mediatype === 'Image'): ?>
                      <img src="<?= base_url('/' . $item['url']) ?>" alt="Image">
                  <?php elseif ($mediatype === 'Video'): ?>
                      <video controls>
                          <source src="<?= base_url('/' . $item['url']) ?>" type="video/mp4">
                      </video>
                  <?php elseif ($mediatype === 'Audio'): ?>
                      <audio controls>
                          <source src="<?= base_url('/' . $item['url']) ?>" type="audio/mp3">
                      </audio>
                  <?php endif; ?>
              </div>
              <div class="media-item-details">
                  <h3><?= $item['filename'] ?></h3>
                  <p data-category="mediatype">Type: <?= $mediatype ?></p>
                  <p data-category="id">ID: <?= $item['id'] ?></p>
                  <p data-category="caption">Caption: <?= $item['caption'] ?></p>
              </div>
              <div class="media-item-actions">
                  <form action="<?= site_url("upload/delete/{$item['id']}") ?>" method="post">
                      <button type="submit">Delete</button>
                  </form>
                  <form action="<?= site_url("upload/update-caption/{$item['id']}") ?>" method="post">
                      <textarea name="caption" rows="3" class="media-item-caption"><?= $item['caption'] ?></textarea>
                      <button type="submit">Update Caption</button>
                  </form>
                  <form action="<?= site_url("upload/update-filename/{$item['id']}") ?>" method="post">
                      <textarea name="filename" rows="3" class="media-item"><?= $item['filename'] ?></textarea>
                      <button type="submit">Update Filename</button>
                  </form>
              </div>
          </div>
      <?php endforeach; ?>
  </div>
  <script>
    const searchButton = document.getElementById('search-button');
    const searchInput = document.getElementById('search-input');
    const searchCategory = document.getElementById('search-category');
    const searchFilter = document.getElementById('search-filter');
    const mediaItems = document.querySelectorAll('.media-item');

    searchButton.addEventListener('click', () => {
        const searchText = searchInput.value.toLowerCase();
        const selectedCategory = searchCategory.value;
        const selectedFilter = searchFilter.value;

        mediaItems.forEach(item => {
            const filenameElement = item.querySelector('.media-item-details h3');
            const filename = filenameElement ? filenameElement.innerText.toLowerCase() : '';

            const idElement = item.querySelector('.media-item-details p[data-category="id"]');
            const id = idElement ? idElement.innerText.split(':')[1].trim().toLowerCase() : '';

            const captionElement = item.querySelector('.media-item-details p[data-category="caption"]');
            const caption = captionElement ? captionElement.innerText.split(':')[1].trim().toLowerCase() : '';

            const mediaTypeElement = item.querySelector('.media-item-details p[data-category="mediatype"]');
            const mediaType = mediaTypeElement ? mediaTypeElement.innerText.split(':')[1].toLowerCase() : '';

            let isMatched = false;

            if (selectedFilter === 'all' ||
                (selectedFilter === 'image' && mediaType.includes('image')) ||
                (selectedFilter === 'video' && mediaType.includes('video')) ||
                (selectedFilter === 'audio' && mediaType.includes('audio'))) {
                switch (selectedCategory) {
                    case 'filename':
                        isMatched = filename.includes(searchText);
                        break;
                    case 'id':
                        isMatched = id.includes(searchText);
                        break;
                    case 'caption':
                        isMatched = caption.includes(searchText);
                        break;
                    default: // All
                        isMatched = filename.includes(searchText) || id.includes(searchText) || caption.includes(searchText);
                }
            }

            if (isMatched) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
    const randomizeButton = document.getElementById('randomize-button');
            const mediaList = document.querySelector('.media-list');

            randomizeButton.addEventListener('click', () => {
                const mediaItems = Array.from(mediaList.children);
                shuffleArray(mediaItems);
                mediaItems.forEach((item) => {
                    mediaList.appendChild(item);
                });
            });

            // Function to shuffle an array
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }
</script>
</body>
</html>
