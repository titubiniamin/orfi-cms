<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@include('components.google-analytic-config')
<style>

.brand-link .brand-image {
    float: none !important;
    line-height: .8;
    margin-left: .8rem;
    margin-right: .5rem;
    margin-top: -3px;
    max-height: 33px;
    width: auto;
}
.question_answer {
    height: 100%;
    width: 950px;
    background:#343a40;
    float: left;
    position: fixed;
    left: -950px;
    top: 0;
    z-index: 5000;
    overflow-y: scroll;
}

#QnACrossBar {
    width: 100%;
    height: 57px;
    background: white;
    padding: 14px;
    padding-left: 33px;
    font-size: 20px;
}
.close-button{
    cursor: pointer;
    float: right;
}

/* width */
::-webkit-scrollbar {
  width: 3px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 3px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: black;
  border-radius: 3px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: gray;
}

.QnACard {
   margin: 0px !important;
   border-radius: 0 !important
}
</style>
@stack('css')
