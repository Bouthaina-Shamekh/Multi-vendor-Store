<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(''),
            'locales' => Languages::getNames(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2'],
        ]);

        $user = $request->user();

        // هاي ازا كان اليوزر جديد هتعملو اضافة ازا كان موجود هتعملو تعديل
        $user->profile->fill( $request->all() )->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated!');


            // بهاد الحالة لو كان عندي يوزر بس ملوش لسا بروفايل
        // $profile = $user->profile;
        // if ($profile->first_name) {
        //     $profile->update($request->all());
        // } else {
        //     // $request->merge([
        //     //     'user_id' => $user->id,
        //     // ]);
        //     // Profile::create($request->all());

        //     $user->profile()->create($request->all());
        // }


    }
}
