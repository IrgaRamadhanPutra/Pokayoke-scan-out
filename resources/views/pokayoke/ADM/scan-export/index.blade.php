{{-- @extends('layouts.admin.app') --}}
{{-- @section('content') --}}
@extends('layouts.admin.app', ['title' => 'Dashboard'])
@section('judul')
    SCAN - ADM EXPORT
@endsection(judul')
<style>
    /* Custom Spinner Styles */
.loading-spinner-container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin: 1rem 0;
}

.loading-spinner {
    border: 4px solid rgba(0, 0, 0, 0.1); /* Light grey */
    border-radius: 50%;
    border-top: 4px solid #007bff; /* Primary color */
    width: 3rem;
    height: 3rem;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-spinner-container span {
    margin-top: 0.5rem;
    color: #007bff; /* Primary color */
}

</style>
@section('content')
<div class="card">
    <div class="card-body">
        <form id="form">
            <form id="form">
                @csrf
                <div class="form-outline mb-4">
                    <p class="text-danger"><b><i>*Kanban Customer*</i></b></p>
                    <input type="hidden" name="dn_no" id="dn_no">
                    <input type="hidden" name="job_no" id="job_no">
                    <input type="hidden" name="part_no" id="part_no">
                    <input type="text" class="form-control" id="input1" name="input1" placeholder="" value="" required="">
                </div>
                <div class="form-outline mb-4">
                    <p class="text-danger"><b><i>*Kanban Internal*</i></b></p>
                    <input type="text" class="form-control" id="input2" name="input2" placeholder="" value="" required="">
                </div>
                <div class="loading-spinner-container" style="display:none;">
                    <div class="loading-spinner"></div>
                    <span>Loading..</span>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"
                        style="float: left; font-size: 15px;" value="cancel">RESET</button>
                </div>

                <audio id="Audiosucces" src="{{ asset('audio/succes.mp3') }}"></audio>
                <audio id="Audioerror" src="{{ asset('audio/error.mp3') }}"></audio>

            </form>

    </div>
    @include('pokayoke.ADM.scan-export.ajax')
</div>
@endsection('content')
