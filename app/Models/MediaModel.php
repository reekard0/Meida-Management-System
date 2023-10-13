<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $DBGroup = 'default';
    protected $table      = 'Media';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['userid', 'url', 'mediatype', 'caption', 'filename', 'id'];

    public function findAllByUserId($userId)
    {
        return $this->where('userid', $userId)->where('deleted_at', null)->findAll();
    }

    public function deleteMedia($id)
    {
        return $this->delete($id);
    }

    public function updateCaption($id, $caption)
    {
        return $this->update($id, ['caption' => $caption]);
    }

    public function updateFilename($id, $filename)
    {
        return $this->update($id, ['filename' => $filename]);
    }

    public function upload($file, $url, $name, $extension, &$errors)
    {
        $username = session()->get('username');

        $userModel = new \App\Models\ServerModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            $errors[] = 'User not found.';
            return false;
        }

        $data = [
            'userid' => session()->get('userid'),
            'url' => $url,
            'mediatype' => $extension,
            'filename' => $name,
        ];

        $this->insert($data);
        return true;
    }
}
