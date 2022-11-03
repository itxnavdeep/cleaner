<?php

namespace App\Http\Livewire\Cleaner;

use Livewire\Component;
use App\Models\User;
use App\Models\UserDetails;

class Account extends Component
{

    public $email, $timezone, $first_name, $last_name, $contact_number, $address, $about;

    public $fieldStatus = false, $action;

    public function editData($userId, $action)
    {
        $user = User::find($userId);
        $this->userId = $userId;
        if ($action == 'name') {
            $this->name = $user->name;
        }
        if ($action == 'contact_number') {
            $this->contact_number = $user->contact_number;
        }
        if ($action == 'email') {
            $this->email = $user->email;
        }
        if ($action == 'address') {
            $this->address = $user->UserDetails->address;
        }
        if ($action == 'about') {
            $this->about = $user->UserDetails->about;
        }
        if ($action == 'image') {
            $this->image = $user->image;
        }
        $this->action = $action;

        $this->fieldStatus = true;
    }

    public function cancle()
    {
        $this->fieldStatus = false;
    }

    public function updateData($action)
    {

        if ($this->userId) {
            $user = User::find($this->userId);
            $userdetail = $user->UserDetails;
            if ($action == 'name') {
                $name = explode(' ', $this->name);
                $user->first_name = @$name[0];
                $user->last_name = @$name[1];
            }
            if ($action == 'contact_number') {
                $user->contact_number = $this->contact_number;
            }
            if ($action == 'email') {
                $user->email = $this->email;
            }

            $user->update();

            if ($action == 'address') {
                $userdetail->address = $this->address;
            }
            if ($action == 'about') {
                $userdetail->about = $this->about;
            }

            $userdetail->update();
            $this->fieldStatus = false;
        }
    }
    public function imageUpload($id)
    {

        if ($id) {
            $user = User::find($id);
            dd($user->image);
            if ($user->image && strpos($user->image, "data:") !== false) {
                $this->image = $user->image;
dd($this->image);
                $folderPath = ('storage/images/');
                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0775, true);
                    chown($folderPath, exec('whoami'));
                }

                $image_parts = explode(";base64,", $image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_base64 = base64_decode($image_parts[1] ?? null) ?? null;
                $file_name = $user->id . '-' . md5(uniqid() . time()) . '.png';
                $imageFullPath = $folderPath . $file_name;
                file_put_contents($imageFullPath, $image_base64);

                //...
                $user->image = $file_name;
            }
            $user->save();
        }
    }

    public function render()
    {
        $user = User::findOrFail(auth()->user()->id);
        return view('livewire.cleaner.account', ['user' => $user]);
    }
}
