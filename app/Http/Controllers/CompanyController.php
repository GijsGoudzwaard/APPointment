<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\File;
use App\Jobs\Verify;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Verify
{
    /**
     * Show the company of the logged in user
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        // Check if we need to show all the companies or not
        if ($request->path() == 'companies') {
            $companies = Company::all();

            return view('pages.company.index', compact('companies'));
        }

        return view('pages.company.edit', [
            'company' => get_company()
        ]);
    }

    /**
     * Show the create form
     *
     * @return mixed
     */
    public function create()
    {
        return view('pages.company.create', [
            'days' => (new Company)->days
        ]);
    }

    /**
     * Create a new company
     *
     * @param  Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = $this->verify($request->all());

        if ($validator) {
            return $validator;
        }

        $company = new Company;
        $opening_hours = [];

        foreach ($request->get('from') as $key => $from) {
            $opening_hours[$key] = [
                'from' => $from,
                'to' => $request->get('to')[$key]
            ];
        }

        $company->fill($request->all());
        $company->subdomain = clean_string($request->get('subdomain'));
        $company->opening_hours = json_encode($opening_hours);

        if ($request->hasFile('logo')) {
            $path = File::upload($request, 'logo');

            if (is_array($path)) {
                return redirect()->back()->with('errors', $path)->withInput();
            }

            $company->logo = $path ?? $company->logo;
        }

        $company->save();

        return redirect('companies/' . $company->id . '/edit')->with('success', 'Successfully created');
    }

    /**
     * Show the edit form
     *
     * @param int     $company_id
     * @param Request $request
     * @return mixed
     */
    public function edit($company_id, Request $request)
    {
        $company = Company::find($company_id);

        if (strpos($request->path(), 'companies') !== false) {
            $allowed = true;
        }

        return view('pages.company.edit', [
            'company' => $company,
            'allowed' => $allowed ?? false
        ]);
    }

    /**
     * Update a company by its $id
     *
     * @param  Request $request
     * @param  int     $company_id
     * @return mixed
     */
    public function update(Request $request, $company_id)
    {
        $company = Company::find($company_id);
        $validator = $this->verify($request->all(), $company);

        if ($validator) {
            return $validator;
        }

        if (strpos($request->path(), 'companies') !== false) {
            $allowed = true;
        }

        $opening_hours = [];
        foreach ($request->get('from') as $key => $from) {
            $opening_hours[$key] = [
                'from' => $from,
                'to' => $request->get('to')[$key]
            ];
        }

        $company->fill($request->all());

        if (isset($allowed) && $allowed) {
            $company->subdomain = clean_string($request->get('subdomain'));
        }

        $company->opening_hours = json_encode($opening_hours);

        if ($request->hasFile('logo')) {
            $path = File::upload($request, 'logo');

            if (is_array($path)) {
                return redirect()->back()->with('errors', $path)->withInput();
            }

            $company->logo = $path ?? $company->logo;
        }

        $company->save();

        return redirect()->back()->with('success', 'Successfully updated');
    }

    /**
     * Delete a company
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return redirect()->back()->with('success', 'Successfully deleted');
    }

    /**
     * Create a new Validor instance
     *
     * @param  Request $request
     * @param  Company $company
     * @return Validator
     */
    public function validator($request, $company = null)
    {
        return Validator::make($request, [
            'name' => 'required|max:255',
            'subdomain' => (request()->path() == 'companies' ? 'required' : '') . '|max:255',
            'email' => 'required|email|' . (isset($company) && $company->email == $request['email']) ? '' : '|unique:users' . '|max:255',
            'address' => 'required',
            'phonenumber' => 'required'
        ]);
    }
}
