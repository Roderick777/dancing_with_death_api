<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            /* .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            } */
        </style>
    </head>
    <body>
        <div class="" id="app">
            <!-- As a heading -->
            <nav class="navbar navbar-light bg-light mb-3">
                <span class="navbar-brand mb-0 h1">Dancing with the death</span>
            </nav>
            <template v-if="paginaActiva.menu == 'principal'">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="contenedor_calendario">
                                    <div class="event-calendar__grid">
                                        <div class="days-of-week">
                                            <div>Mo</div>
                                            <div>Tu</div>
                                            <div>We</div>
                                            <div>Th</div>
                                            <div>Fr</div>
                                            <div>Sa</div>
                                            <div>Su</div>
                                        </div>
                                        <div class="week" v-for="(week, indexWeek) in month" :key="week.week">
                                            <div class="day" :class="{ 'is-today': isToday(day), 'dia-elegido': isChoosen(day) }" v-for="(day, index) in week.days" :key="index" v-on:click="elegirDia(day, index)">
                                                <div class="day__header">@{{ day.format('DD') }}</div>
                                                <div class="day__events">
                                                    <div class="event event-dot" v-for="event in eventsOf(day)" :key="event.id"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <transition name="fade">
                                    <div class="badge badge-info" v-if="diaElegido == null">Seleccione una fecha del calendario para revisar los eventos agendados</div>
                                </transition>
                             
                                <template>
                                <transition name="fade">
                                    <div v-if="diaElegido != null" >
                                        <div class="col-12">
                                            <div class="badge badge-info" v-if="eventsOf(diaElegido) == undefined">El Día seleccionado no tiene eventos asociados</div>
                                            <h3 class="text-primary" v-if="eventsOf(diaElegido) != undefined">Eventos</h3>
                                            <div class="row">
                                                <div class="col-6" v-for="event in eventsOf(diaElegido)">
                                                    <div class="card card-evento">
                                                        <div class="card-body">
                                                        @{{ event.name }}
                                                        <div class="badge badge-primary">@{{ event.starts_at}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h3 class="text-primary" v-if="eventsOf(diaElegido) != undefined">Distribución de horas</h3>
                                            <svg style="width:100%;">
                                                <g>
                                                    <rect v-for="(hora, indexHora) in horas"  style="fill:#ddd;stroke-width:1;stroke:rgb(255,255,255);" :x="horaSize*indexHora"  y="10" :width="horaSize" height="100"/>
                                                    <text v-for="(hora, indexHora) in horas" font-size="11" :x="(horaSize*indexHora) + 5" y="35" fill="cadetblue">@{{hora.hora}}</text>
                                                    <rect @mouseenter="setDetalleGrafico(event)" @mouseleave="salirDetalleGrafico()" v-for="(event, indexEvent) in eventsOf(diaElegido)"  style="fill:rgba(255,50,10,.5);stroke-width:1;stroke:rgba(255,50,10,.9);" :x="calcularPosicion(event, indexEvent)"  y="48" :width="horaSize" height="50"/>
                                                </g>                                                  
                                            </svg>

                                        </div>
                                        
                                    </div>
                                </transition>
                                </template>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Agendar cita</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </template>




                        
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <!-- <h4 class="modal-title">Modal Header</h4> -->
                    </div>
                    <div class="modal-body">
                        <p>Selecciona el día y hora que deseas agendar para tu danza con la muerte</p>
                        <datepicker v-model="form.fecha"></datepicker>   
                        <vue-timepicker v-model="form.hora" format="HH:mm:ss"></vue-timepicker>
                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>

                </div>
            </div>
            <transition name="fade">

            <div class="detalle-grafico bg-primary" v-if="detalleGrafico != null">
                <div class="badge bagde-light" v-text="detalleGrafico.name"></div>
                <div class="badge bagde-light" v-text="detalleGrafico.starts_at"></div>

            </div>
            </transition>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
