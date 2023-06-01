<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use OpenAI\Laravel\Facades\OpenAI;

class AvatarController extends Controller
{

    /**
     * Update the user's profile information.
     */
    public function update(UpdateAvatarRequest $request)
    {
        $path = Storage::disk('public')->put("avatars/{$request->user()->id}", $request->file('avatar'));


        if ($oldAvatar = $request->user()->avatar) {
            Storage::disk('public')->delete("avatars/{$request->user()->id}/$oldAvatar");
        }


        auth()->user()->update(['avatar' => basename($path)]);


        return redirect(route('profile.edit'))->with('message', 'Avatar is updated!');
    }

    /**
     * Update the user's profile information.
     */
    public function generate(Request $request)
    {

        $result = OpenAI::images()->create([
            "prompt" => 'create avatar for user single figure',
            'n'      => 1,
            'size'   => "256x256",
        ]);

        $contents = file_get_contents($result->data[0]->url);

        $filename = Str::random(25);

        Storage::disk('public')->put("avatars/{$request->user()->id}/$filename.jpg", $contents);

        if ($oldAvatar = $request->user()->avatar) {
            Storage::disk('public')->delete("avatars/{$request->user()->id}/$oldAvatar");
        }

        auth()->user()->update(['avatar' => "$filename.jpg"]);


        return redirect(route('profile.edit'))->with('message', 'Avatar is updated!');
    }
}
