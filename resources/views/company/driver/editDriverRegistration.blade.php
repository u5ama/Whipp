@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Edit Driver Registration</h4>
                <span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $driver_id }}">
                        <input type="hidden" id="form-method" value="edit">
                        <input type="hidden" id="form-method" value="add">
                        <div class="row row-sm">
                            <div class="col-12 border-bottom border-top mb-3  p-3 bg-light">
                                <div class="main-content-label mb-0">{{ 'Driver License' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.driver_license_number_title') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="driver_license_number"
                                           id="driver_license_number"
                                           placeholder="{{ config('languageString.driver_license_number_title') }}"
                                           value="@if(isset($driverProfile->dp_license_number)){{$driverProfile->dp_license_number}}@endif"
                                           required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @if(isset($driverLicenseFiles) && count($driverLicenseFiles) > 0)
                                @foreach($driverLicenseFiles as $driverLicense)
                                    @if($driverLicense->bm_section_order == 0)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="license_front_image">{{ config('languageString.front_image_title') }}<span class="error">*</span></label>
                                                <input type="file" class="form-control dropify"
                                                       name="license_front_image"
                                                       id="license_front_image"
                                                       data-default-file="{{ asset($driverLicense->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($driverLicense->bm_section_order == 1)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.back_image_title') }}<span class="error">*</span></label>
                                                <input type="file" class="form-control dropify"
                                                       name="license_back_image"
                                                       id="license_back_image"
                                                       data-default-file="{{ asset($driverLicense->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="license_front_image">{{ config('languageString.front_image_title') }}<span class="error">*</span></label>
                                        <input type="file" class="form-control dropify"
                                               name="license_front_image"
                                               id="license_front_image" required=""/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.back_image_title') }}<span class="error">*</span></label>
                                        <input type="file" class="form-control dropify"
                                               name="license_back_image"
                                               id="license_back_image"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 border-bottom border-top mb-3  p-3 bg-light">
                                <div class="main-content-label mb-0">{{ 'Personal ID Card' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.company_personal_id_card_title') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="personal_id_card"
                                           id="personal_id_card"
                                           placeholder="{{ config('languageString.company_personal_id_card_title') }}"
                                           value="@if(isset($driverProfile->dp_personal_id)){{$driverProfile->dp_personal_id}}@endif"
                                           required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @if(isset($driverPersonalIdFiles) && count($driverPersonalIdFiles) > 0 )

                                @foreach($driverPersonalIdFiles as $driverPersonal)
                                    @if($driverPersonal->bm_section_order == 0)

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.front_image_title') }}<span class="error">*</span></label>
                                                <input type="file" class="form-control dropify"
                                                       name="personal_front_image"
                                                       id="personal_front_image"
                                                       data-default-file="{{ asset($driverPersonal->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($driverPersonal->bm_section_order == 1)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.back_image_title') }}<span class="error">*</span></label>
                                                <input type="file" class="form-control dropify"
                                                       name="personal_back_image"
                                                       id="personal_back_image"
                                                       data-default-file="{{ asset($driverPersonal->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.front_image_title') }}<span class="error">*</span></label>
                                        <input type="file" class="form-control dropify"
                                               name="personal_front_image"
                                               id="personal_front_image" required=""/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.back_image_title') }}<span class="error">*</span></label>
                                        <input type="file" class="form-control dropify"
                                               name="personal_back_image"
                                               id="personal_back_image"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 border-bottom border-top mb-3  p-3 bg-light">
                                <div class="main-content-label mb-0">{{ 'Car Registration' }}</div>
                            </div>
                            @if(isset($carRegistrationFiles) && count($carRegistrationFiles) > 0)

                                @foreach($carRegistrationFiles as $carReg)
                                    @if($carReg->bm_section_order == 0)
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.main_image_title') }}<span class="error">*</span></label>
                                                <input type="file" class="form-control dropify"
                                                       name="car_regitration_images"
                                                       id="car_regitration_images"
                                                       data-default-file="{{ asset($carReg->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.main_image_title') }}<span class="error">*</span></label>
                                        <input type="file" class="form-control dropify"
                                               name="car_regitration_images"
                                               id="car_regitration_images" required=""/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif
                            @if(isset($transportTypes))
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="type_id">{{ config('languageString.transport_type_title') }}<span
                                            class="error">*</span></label>
                                    <select id="type_id" name="type_id" class="form-control" required>
                                        <option value="">Please Select Transport Type</option>
                                        @foreach($transportTypes as $type)
                                            <option value="{{ $type->id }}"
                                                    @if(isset($driverProfile->dp_transport_type_id_ref) && $type->id==$driverProfile->dp_transport_type_id_ref) {{'selected'}} @endif
                                            >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="type_id">{{ config('languageString.transport_type_title') }}<span
                                                class="error">*</span></label>
                                        <select id="type_id" name="type_id" class="form-control" required>
                                            <option value="">Please Select Transport Type</option>
                                            @foreach($transportTypes as $type)
                                                <option value="{{ $type->id }}"
                                                @if(isset($driverProfile->dp_transport_type_id_re) && $type->id==$driverProfile->dp_transport_type_id_ref) {{'selected'}} @endif
                                                >{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="make_id">Transport Make<span
                                            class="error">*</span></label>
                                    <select id="make_id" name="make_id" class="form-control" required>
                                        <option value="">Please Select Transport Make</option>
                                        @foreach($transportMakes as $make)
                                            <option value="{{ $make->id }}"
                                                    @if($make->id==$driverProfile->dp_transport_make_id) selected @endif
                                            >{{ $make->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="model_id">{{ config('languageString.company_transport_model_title') }}<span
                                            class="error">*</span></label>
                                    <select id="model_id" name="model_id" class="form-control" required>
                                        <option value="">Please Select Transport Model</option>
                                        @foreach($transportModels as $models)
                                            <option value="{{ $models->id }}"
                                                    @if($models->id==$driverProfile->dp_transport_model_id) selected @endif
                                            >{{ $models->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="model_color_id">{{ config('languageString.company_transport_model_color_title') }}<span
                                            class="error">*</span></label>
                                    <select id="model_color_id" name="model_color_id" class="form-control" required>
                                        <option value="">Please Select Transport Model Color</option>
                                        @foreach($transportModelColors as $modelColor)
                                            <option value="{{ $modelColor->id }}"
                                                    @if($modelColor->id==$driverProfile->dp_transport_color_id) selected @endif
                                            >{{ $modelColor->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="model_color_id">{{ config('languageString.company_transport_model_year_title') }}<span
                                            class="error">*</span></label>
                                    <select id="model_year_id" name="model_year_id" class="form-control" required>
                                        <option value="">Please Select Transport Model Year</option>
                                        @foreach($transportModelYears as $modelYear)
                                            <option value="{{ $modelYear->id }}"
                                            @if($modelYear->id==$driverProfile->dp_transport_year_id) {{'selected'}} @endif
                                            >{{ $modelYear->tmy_name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            @if(isset($driverProfile->car_registration))
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.company_car_registration_title') }}<span
                                            class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="car_reg"
                                           id="car_reg"
                                           placeholder="{{ config('languageString.company_car_registration_title') }}" value="{{$driverProfile->car_registration}}"
                                           required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">{{ config('languageString.company_car_registration_title') }}<span
                                                class="error">*</span></label>
                                        <input type="text" class="form-control"
                                               name="car_reg"
                                               id="car_reg"
                                               placeholder="{{ config('languageString.company_car_registration_title') }}" value=""
                                               required/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($driverProfile->dp_fuel_id_ref) && count($transportFuel) > 0)

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tm_type_ref_id">{{ config('languageString.fuel_type_title') }}<span
                                            class="error">*</span></label>
                                    <select id="fuel_type_id" name="fuel_type_id" class="form-control" required>
                                        <option value="">Please Select Fuel Type</option>
                                        @foreach($transportFuel as $fuelType)
                                            <option value="{{ $fuelType->id }}"
                                                    @if($fuelType->id == $driverProfile->dp_fuel_id_ref) {{'selected'}} @endif >{{ $fuelType->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="tm_type_ref_id">{{ config('languageString.fuel_type_title') }}<span
                                                class="error">*</span></label>
                                        <select id="fuel_type_id" name="fuel_type_id" class="form-control" required>
                                            <option value="">Please Select Fuel Type</option>
                                            @foreach($transportFuel as $fuelType)
                                                <option value="{{ $fuelType->id }}">{{ $fuelType->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.company_date_of_manufacture') }}<span
                                            class="error">*</span></label>
                                    <input type="date" class="form-control"
                                           name="date_manufacture"
                                           id="date_manufacture"
                                           placeholder="{{ config('languageString.company_date_of_manufacture') }}"
                                           value="@if(isset($driverProfile->dp_date_manufacture)){{$driverProfile->dp_date_manufacture}}@endif" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ config('languageString.company_date_of_registration_title') }}n<span
                                            class="error">*</span></label>
                                    <input type="date" class="form-control"
                                           name="date_reg"
                                           id="date_reg"
                                           placeholder="{{ config('languageString.company_date_of_registration_title') }}"
                                           value="@if(isset($driverProfile->dp_date_registration)){{$driverProfile->dp_date_registration}}@endif" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            @if(isset($carRegistrationFiles) && count($carRegistrationFiles) > 0)
                                @foreach($carRegistrationFiles as $carReg)
                                    @if($carReg->bm_section_order == 1)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.car_certificate_front_image_title') }}</label>
                                                <input type="file" class="form-control dropify"
                                                       name="car_cert_front"
                                                       id="car_cert_front"
                                                       data-default-file="{{ asset($carReg->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($carReg->bm_section_order == 2)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">{{ config('languageString.car_certificate_back_image_title') }}</label>
                                                <input type="file" class="form-control dropify"
                                                       name="car_cert_back"
                                                       id="car_cert_back"
                                                       data-default-file="{{ asset($carReg->bm_file_path) }}"/>
                                                <div class="help-block with-errors error"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.car_certificate_front_image_title') }}</label>
                                        <input type="file" class="form-control dropify"
                                               name="car_cert_front"
                                               id="car_cert_front"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">{{ config('languageString.car_certificate_back_image_title') }}</label>
                                        <input type="file" class="form-control dropify"
                                               name="car_cert_back"
                                               id="car_cert_back"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 border-bottom border-top mb-3  p-3 bg-light">
                                <div class="main-content-label mb-0">{{ 'Car Mutiple Images' }}
                                    <a href="javascript:void(0)"
                                       class="btn btn-sm btn-outline-info waves-effect waves-light"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Add More File"><i
                                            class="bx bx-plus font-size-16 align-middle" onclick="addMoreFiles();"></i></a>
                                </div>
                            </div>
                            @if(isset($carMultiImages) && count($carMultiImages) > 0)
                                @foreach($carMultiImages as $key => $carMReg)
                                    <div class="col-3">
                                        <input type="hidden" name="countimage" value="1" id="countimage">
                                        <div class="form-group">
                                            <label for="image"></label>
                                            <input type="file" class="form-control dropify"
                                                   name="carm" data-default-file="{{ asset($carMReg->bm_file_path) }}"
                                                   id="carm"/>
                                            <div class="help-block with-errors error"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-6">
                                    <input type="hidden" name="countimage" value="3" id="countimage">
                                    <div class="form-group">
                                        <label for="image">Image - 1</label>
                                        <input type="file" class="form-control dropify"
                                               name="car_images[]"
                                               id="car_images"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">Image - 2</label>
                                        <input type="file" class="form-control dropify"
                                               name="car_images[]"
                                               id="car_images"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endif
                            @for($i=0;$i<8;$i++)
                                <div class="col-6" id="newimage_{{$i+1}}" style="display: none">
                                    <div class="form-group">
                                        <label for="image">Image - {{$i+1}}</label>
                                        <input type="file" class="form-control dropify"
                                               name="car_images[]"
                                               id="car_images"/>
                                        <div class="help-block with-errors error"></div>
                                    </div>
                                </div>
                            @endfor

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit" class="btn btn-primary">{{ config('languageString.save_and_finish_button') }}</button>
                                        <a href="{{ url('company/driver') }}"
                                           class="btn btn-secondary">{{ config('languageString.cancel_button') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{URL::asset('assets/js/custom/company/driverRegistration.js')}}?v={{ time() }}"></script>

@endsection
