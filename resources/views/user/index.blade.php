@extends('layouts.user')

@section('content')
<script>
    window.location.href = "{{ route('user.calendar') }}";
</script>
@endsection
