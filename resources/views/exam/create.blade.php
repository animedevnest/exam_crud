@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Exam Question') }}</div>

                <div class="card-body">
                    <form id="validate_form_question">
                        <div class="form-group row">
                            <label for="Question" class="col-md-4 col-form-label text-md-right">{{ __('Question') }}</label>

                            <div class="col-md-6">
                                <input id="question" type="text" class="form-control" name="question" value="{{ old('question') }}" required>

                                <div class="error" id="error_question"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">
                               <select class="selectpicker" required name="category[]" multiple data-live-search="true">
                                
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                               </select>
                               <div class="error" id="error_category"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option1" class="col-md-4 col-form-label text-md-right">{{ __('Option 1') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="option1" id="option1" required>
                                <div class="error" id="error_option1"></div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="option2" class="col-md-4 col-form-label text-md-right">{{ __('Option 2') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="option2" id="option2" required>
                                <div class="error" id="error_option2"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option3" class="col-md-4 col-form-label text-md-right">{{ __('Option 3') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="option3" id="option3" required>
                                <div class="error" id="error_option3"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option4" class="col-md-4 col-form-label text-md-right">{{ __('Option 4') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="option4" id="option4" required>
                                <div class="error" id="error_option4"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
 <script>
      $('.selectpicker').selectpicker({
        style: 'btn-default',
        size: false
    });
        $(document).ready(function(){
        
         $('#validate_form_question').on('submit', function(event){
          event.preventDefault();
        
            var formData = new FormData(document.getElementById('validate_form_question'));
            $.ajax({  
            url: '{{ route("exam.store") }}',
            method:"POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:formData,
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(data)
            {        
                if (data.status == "success")
                {
                    alert("Successfully Submitted!.",);
                    $('#validate_form_question')[0].reset();
                }
                else  if (data.status == "auth_error")
                {
                    alert("Authentication Error!.");    
                }
                else
                    alert("Something went wrong!.");       
                
            },
            error: function (request, status, error) {
                    $('.error').empty();
                    json = $.parseJSON(request.responseText);
                   
                    $.each(json.errors, function(key, value){
                    var error_key='<div class="alert alert-danger" role="alert">'+value+'.</div>';
                    
                    $('#error_'+key).show();
                    $('#error_'+key).append(error_key);
                    });
                }
           });
         });
        
        });
        </script>
@endpush
