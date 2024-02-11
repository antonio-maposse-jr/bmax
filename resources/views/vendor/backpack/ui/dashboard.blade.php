@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type' => 'alert',
        'class' => 'alert alert-info mb-2',
        'heading' => 'Important information!',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti nulla quas distinctio veritatis provident mollitia error fuga quis repellat, modi minima corporis similique, quaerat minus rerum dolorem asperiores, odit magnam.',
        'close_button' => true, // show close button or not
    ];
@endphp

@section('content')
@endsection
