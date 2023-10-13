<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class Upload extends BaseController
{
    protected $helpers = ['form'];
    protected $mediaModel;

    public function delete($id)
    {
        if (!session()->has('username')) {
            return redirect()->to(route('Login'));
        }

        $username = session('username');

        // Load the ServerModel
        $serverModel = new \App\Models\ServerModel();

        // Retrieve the user record from the database by username
        $user = $serverModel->where('username', $username)->first();

        // Check if the user exists and retrieve the user ID
        if ($user) {
            $userId = $user['id'];

            // Load the MediaModel
            $mediaModel = new \App\Models\MediaModel();

            // Retrieve the file record from the database by its ID and user ID
            $file = $mediaModel->where('id', $id)->where('userid', $userId)->first();

            // Check if the file exists
            if ($file) {
                // Delete the file record from the database
                $mediaModel->delete($id);

                // Delete the physical file from the server
                $filePath = WRITEPATH . 'uploads/' . $file['url'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Redirect to the updated media page
        return redirect()->to('/media');
    }



      public function updateCaption($id)
      {
          $media = $this->mediaModel->find($id);
          if (!$media) {
              return redirect()->back()->with('error', 'Media not found.');
          }

          $caption = $this->request->getPost('caption');
          $this->mediaModel->updateCaption($id, $caption);
          return redirect()->back()->with('success', 'Caption updated successfully.');
      }

    public function __construct()
    {
        $this->mediaModel = new \App\Models\MediaModel();
    }

    public function index()
    {
        $data['errors'] = [];
        return view('upload/upload', $data);
    }

    public function upload()
    {
        if (!isset($_SESSION['username'])) {
            return redirect()->route('Login');
        } else {
            $db = new \App\Models\MediaModel();

            $validationRules = [
                'userfile' => [
                    'label' => 'Media File',
                    'rules' => [
                        'uploaded[userfile]',
                        'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp,video/mp4,video/mpeg,video/quicktime,video/x-msvideo,audio/mpeg,audio/ogg,audio/wav,audio/x-wav]',
                        'max_size[userfile,100000000]',
                    ],
                ],
            ];

            if (! $this->validate($validationRules)) {
                $data = ['errors' => $this->validator->getErrors()];
                return view('upload/upload', $data);
            }

            $img = $this->request->getFile('userfile');

            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $extension = $img->getExtension();
                $img->move(ROOTPATH . 'public/uploads', $newName);
                $filepath = 'uploads/' . $newName;
                $file = new \CodeIgniter\Files\File($filepath);
                $data = ['uploaded_fileinfo' => new \CodeIgniter\Files\File($filepath)];
                if ($file->isFile()) {
                    $db->upload($img, $filepath, $newName, $extension, $errors);
                    return view('upload/uploaded', $data);
                } else {
                    $data = ['errors' => 'Failed to move the file. Please try again.'];
                    return view('upload/upload', $data);
                }
            }

            $data = ['errors' => 'The file is invalid or has already been moved.'];
            return view('upload/upload', $data);
        }
    }
}
