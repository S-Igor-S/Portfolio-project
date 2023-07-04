@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Footer Page </h4>

                            <form method="post" action="{{ route('dashboard.footer.update') }}">
                                @csrf

                                <input type="hidden" name="name" value="{{ $templateName }}">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Number</label>
                                    <div class="col-sm-10">
                                        <input name="number" class="form-control" type="text"
                                               value="{{ $elementContent->number ?? '' }}" id="example-text-input">
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Short
                                        Description </label>
                                    <div class="col-sm-10">
                                        <textarea required="" name="short_description" class="form-control" rows="5">
                                            {{ $elementContent->short_description ?? '' }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Adress</label>
                                    <div class="col-sm-10">
                                        <input name="address" class="form-control" type="text"
                                               value="{{ $elementContent->address ?? '' }}" id="example-text-input">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> Email</label>
                                    <div class="col-sm-10">
                                        <input name="email" class="form-control" type="email"
                                               value="{{ $elementContent->email ?? '' }}" id="example-text-input">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-10">
                                        <input name="facebook" class="form-control" type="text"
                                               value="{{ $elementContent->facebook ?? '' }}" id="example-text-input">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-10">
                                        <input name="twitter" class="form-control" type="text"
                                               value="{{ $elementContent->twitter ?? '' }}" id="example-text-input">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Copyright</label>
                                    <div class="col-sm-10">
                                        <input name="copyright" class="form-control" type="text"
                                               value="{{ $elementContent->copyright ?? '' }}" id="example-text-input">
                                    </div>
                                </div>


                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                       value="Update Footer Page">
                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
