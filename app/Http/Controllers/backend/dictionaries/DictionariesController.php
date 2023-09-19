<?php

namespace App\Http\Controllers\backend\dictionaries;

use App\Http\Controllers\Controller;
use App\Models\dictionaries\Dictionaries;
use App\Models\general_settings\GeneralSettings;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DictionariesController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->log('Web Dictionary Viewed');
                

            // $dictionaries = DB::table('dictionaries')->paginate(10);
            // $dictionaries = Dictionaries::paginate(10);
                   $dictionaries = Dictionaries::where('active_status', 1)->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            // return dd(count($dictionaries));
            return view('backend.default.dictionaries.index', compact('dictionaries', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function show(Dictionaries $dictionary)
    {
        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->log('Web Dictionary Info Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.dictionaries.show',
                compact( 'dictionary', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->log('Web Dictionary Create Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.dictionaries.create', compact( 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'english' => 'required',
            'uzbek' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $dictionary = new Dictionaries();
            $dictionary->en_word = $request->english;
            $dictionary->uz_word = $request->uzbek;
            $dictionary->qr_word = $request->karakalpak;
            $dictionary->ru_word = $request->russian;
            $dictionary->en_definition = $request->english_definition;
            $dictionary->uz_definition = $request->uzbek_definition;
            $dictionary->qr_definition = $request->karakalpak_definition;
            $dictionary->ru_definition = $request->russian_definition;
            $dictionary->save();
            $dictionary->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Dictionary Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('dictionaries.index');

        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Dictionaries $dictionary)
    {
        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->log('Web Dictionary Edit Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.dictionaries.edit', compact('dictionary', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, Dictionaries $dictionary)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'english' => 'required',
            'uzbek' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $dictionary = Dictionaries::find($dictionary->id);
            $dictionary->en_word = $request->english;
            $dictionary->uz_word = $request->uzbek;
            $dictionary->qr_word = $request->karakalpak;
            $dictionary->ru_word = $request->russian;
            $dictionary->en_definition = $request->english_definition;
            $dictionary->uz_definition = $request->uzbek_definition;
            $dictionary->qr_definition = $request->karakalpak_definition;
            $dictionary->ru_definition = $request->russian_definition;
            $dictionary->save();
            $dictionary->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Dictionary Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('dictionaries.index');

        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, Dictionaries $dictionary)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Dictionary blocked');

            DB::beginTransaction();
            $dictionary = Dictionaries::find($dictionary->id);
            if ($dictionary->active_status == 0){
                $dictionary->active_status = 1;
            }else{
                $dictionary->active_status = 0;
            }
            $dictionary->save();
            $dictionary->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('dictionaries.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, Dictionaries $dictionary)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Dictionaries')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Dictionary destroyed');

            DB::beginTransaction();
            $dictionary->delete();
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('dictionaries.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}
