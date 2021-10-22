@extends('layouts.app')
@section('content')
<div class="container border">
    @foreach($category_exam->exam as $examqa)
        <h3>{{ $examqa->question }}<h3>
            <ul>
                <li>{{ $examqa->option1 }}</li>
                <li>{{ $examqa->option2 }}</li>
                <li>{{ $examqa->option3 }}</li>
                <li>{{ $examqa->option4 }}</li>
            </ul>
            <a href="{{ url('exam/'.$examqa->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
            <a class="btn btn-sm btn-danger" onclick="deletealert({{$examqa->id}});">delete</a>
            <hr>
    @endforeach   
</div>

@endsection
@push('scripts')
    <script>
        function deletealert(id) {
            var result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                    url:'{{ url("exam/destroy")}}',
                    type:"POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{
                        id:id,
                    },
                    success:function(data)
                    {
                        if(data.status == "success")
                        {
                            alert("Your data has been Successfully deleted.");
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        }
                        else
                        {                               
                            alert("Oops something went wrong.");
                        }

                    },
                });
            }
        }
    </script>
@endpush