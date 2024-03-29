@extends('layouts/timerLayout')

@section('contenido') <!-- sirve para referenciar al yield-->
<!--{!! Form::open(['url' => 'registrarcontacto']) !!}
        ==================================================
            Global Page Section Start
        ================================================== -->
        <section class="global-page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h2>Contacto</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="{{route('home')}}">
                                        <i class="ion-ios-home"></i>
                                        Inicio
                                    </a>
                                </li>
                                <li class="active">Contacto</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--/#page-header-->


        <!--
        ==================================================
            Contact Section Start
        ================================================== -->
        <section id="contact-section">
            <div class="container">
                <div class="row">
                    @if(Session()->has('flash_message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{session()->get('flash_message')}}
                    </div>
                    @endif
                    <!--@if($errors->any())
                          <div class="alert alert-danger">
                              @foreach($errors->all() as $error)
                                  <p>{{ $error }}</p>
                              @endforeach
                          </div>
                    @endif-->
                    <div class="col-md-6">
                        <div class="block">
                            <h2 class="subtitle wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Contactenos</h2>
                            <p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
                                Escriba su consulta o cuentenos su situación, le responderemos a la brevedad
                            </p>
                            <div class="contact-form">
                                <form id="contact-form" method="post" action="{{route ('storecontact')}}" role="form">
                                {{ csrf_field() }}
                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".6s">
                                        <input type="text" placeholder="Nombre" class="form-control" name="nombre" id="name" required>
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".8s">
                                        <input type="email" placeholder="Email" class="form-control" name="correo" id="email" required>
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1s">
                                        <input type="text" placeholder="Asunto" class="form-control" name="asunto" id="subject" required>
                                    </div>

                                    <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.2s">
                                        <textarea rows="6" placeholder="Cuentenos su caso" class="form-control" name="consulta" id="body" required></textarea>
                                    </div>


                                    <div id="submit" class="wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.4s">
                                        <input type="submit" id="contact-submit" class="btn btn-default btn-send" value="Enviar Consulta">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="map-area">
                            <h2 class="subtitle  wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Encuentrenos</h2>
                            <p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
                                Nuestra oficina se encuentra ubicada en

                            </p>
                            <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d191.53939553049312!2d-73.24535679541263!3d-39.81528323606096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9615ee76f42ef353%3A0x78da7436bc4e64ba!2sRadio+Pilmaiquen!5e0!3m2!1ses!2scl!4v1510724314275" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row address-details">
                    <div class="col-md-6">
                        <div class="address wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".5s">
                            <i class="ion-ios-location-outline"></i>
                            <p>Arauco 340 Valdivia, Región de los Ríos</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="phone wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".9s">
                            <i class="ion-ios-telephone-outline"></i>
                            <p>+56950525853 </p>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
@stop
