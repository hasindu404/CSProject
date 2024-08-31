@extends(backpack_view('blank'))

@php
   
   
        $widgets['before_content'][] = [
            'type'        => 'jumbotron',
            'heading'     => trans('backpack::base.welcome'),
            'content'     => trans('backpack::base.use_sidebar'),
            'button_link' => backpack_url('logout'),
            'button_text' => trans('backpack::base.logout'),
        ];
        Widget::add()
            ->to('before_content')
            ->type('div')
            ->class('row mt-3')
            ->content([
                    Widget::make()
                        ->type('progress')
                        ->class('card mb-3')
                        ->statusBorder('start')
                        ->accentColor('primary')
                        ->ribbon('top','la-user')
                        ->progressClass('progress-bar')
                        ->value(239)
                        ->description('Registered users')
                        ->progress(100*(int)239 /1000 )
                        ->hint( '8544 more until next milestone.')
            
            
            
            ]);
@endphp

@section('content')
@endsection
