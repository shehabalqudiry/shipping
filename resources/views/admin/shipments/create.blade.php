@extends('admin.layouts.app')
@section('title', 'تحميل اكسل شيت شحنات لمستخدم واحد')
@section('content')

<div class="row">
    <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
        <h5>تحميل اكسل شيت شحنات لمستخدم واحد</h5>
        </div>
        <form class="form theme-form" method="POST" action="{{ route('admin.import.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الملف</label>
            <div class="col-sm-9">
                <input class="form-control @error('importFile') is-invalid @enderror" name="importFile" type="file">
                @error('importFile')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>

            <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">المستخدم</label>
            <div class="col-sm-9">
                <select class="js-example-basic-single form-control @error('user_id') is-invalid @enderror" name="user_id">
                <option value="" selected>اختار ...</option>
                @forelse (App\Models\User::get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @empty
                    لا يوجد مستخدمين حاليا
                @endforelse
                </select>
                @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">حفظ</button>
        </div>
        </form>
    </div>
    </div>
</div>

@endsection
