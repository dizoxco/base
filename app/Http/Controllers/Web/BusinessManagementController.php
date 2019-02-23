<?php

namespace App\Http\Controllers\Web;

use Auth;
use Throwable;
use App\Models\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Profile\Business\StoreBusinessRequest;
use App\Http\Requests\Profile\Business\UpdateBusinessRequest;

class BusinessManagementController extends Controller
{
    public function index()
    {
        return view('profile.businesses.index')->withBusinesses(Auth::user()->businesses);
    }

    public function create()
    {
        $form = [
            'action' => route('profile.businesses.store'),
            'method' => 'post',
        ];

        return view('profile.businesses.create', compact('form'));
    }

    public function store(StoreBusinessRequest $request)
    {
        try {
            $contacts = $this->validateContacts($request->post('contact'));
            if ($contacts instanceof RedirectResponse) {
                return $contacts; // redirect back
            }

            $business = Auth::user()->businesses()->create(
                $request->merge(['contact' => $contacts])->all()
            );
        } catch (Throwable $throwable) {
            return redirect()->back()
                ->withErrors(['server' => trans('http.bad_request')])
                ->withInput();
        }

        return redirect()->route('profile.businesses.show', $business->slug);
    }

    public function validateContacts(array $contacts)
    {
        $result = [];
        foreach ($contacts as $key => $contact) {
            $titles = array_filter($contact['title']);
            $values = array_filter($contact['value']);

            $length = max(count($titles), count($values)) - 1;
            for ($i = 0; $i <= $length; $i++) {
                if (! isset($titles[$i]) || ! isset($values[$i])) {
                    return redirect()->back()
                        ->withErrors(['required' => "contact[{$key}][title][$i]}"])
                        ->withInput();
                }
                $result[$key]['title'][$i] = $titles[$i];
                $result[$key]['value'][$i] = $values[$i];
            }
        }

        return $result;
    }

    public function show(Business $business)
    {
        return view('profile.businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        $form = [
            'action' => route('profile.businesses.update', $business->slug),
            'method' => 'put',
        ];

        return view('profile.businesses.create', compact('business', 'form'));
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        try {
            $contacts = $this->validateContacts($request->post('contact'));
            if ($contacts instanceof RedirectResponse) {
                return $contacts; // redirect back
            }

            $business->update($request->merge(['contact' => $contacts])->all());
        } catch (Throwable $throwable) {
            return redirect()->back()
                ->withErrors(['server' => trans('http.bad_request')])
                ->withInput();
        }

        return redirect()->route('profile.businesses.show', $business->slug);
    }
}
