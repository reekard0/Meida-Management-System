<?php

namespace App\Controllers;

use App\Models\MediaModel;
use CodeIgniter\Controller;

class Media extends Controller
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



    public function updateFilename($id)
    {
        if (!session()->has('username')) {
            return redirect()->to(route('Login'));
        }

        $username = session('username');
        $serverModel = new \App\Models\ServerModel();
        $mediaModel = new \App\Models\MediaModel();
        $user = $serverModel->where('username', $username)->first();

        if ($user) {
          $userId = $user['id'];
          $media = $mediaModel->find($id);
          if (!$media) {
              return redirect()->back()->with('error', 'Media not found.');
          }

          $filename = $this->request->getPost('filename');
          $mediaModel->updateFilename($id, $filename);
          return redirect()->back()->with('success', 'Filename updated successfully.');
      }
    }

    public function index()
    {
        $mediaModel = new \App\Models\MediaModel();
        $userId = session()->get("userid");
        $data['media'] = $mediaModel->findAllByUserId($userId);
        return view('media', $data);
    }
}
