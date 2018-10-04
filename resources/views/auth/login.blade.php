
@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
            
              <div class="card-body">
                <h1>{{$h1}}</h1>
                
                <p class="text-muted"><?php echo $text_register_account; ?></p>
                @if (session()->get( 'success' ))
                <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> 
                {{session()->get( 'success' )}}
                </div>
                @endif
                
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  
                  <input type="text" name="email" value="{{$email}}" id="input-email" class="form-control" placeholder="Email" autofocus required/>
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                    <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" placeholder="Password" class="form-control" required/>
                </div>
                <div class="row">
                  <div class="col-6">
                      <button type="submit" name="submit" class="btn btn-primary px-4">Login</button>
                  </div>
                </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2>Silahkan masuk ke dalam akun kamu</h2>
                  <p>Semua yang anda butuhkan ada disni</p>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
