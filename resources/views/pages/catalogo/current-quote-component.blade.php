<div class="container mx-auto max-w-7xl py-2">
    <div class="grid sm:grid-cols-7 grid-cols-1">
        <div class="sm:col-span-5 col-span-1 px-6">
            <div class="font-semibold text-slate-700 py-8 flex items-center space-x-2">
                <div class="w-16">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </div>

                <p class="text-4xl">CARRITO</p>
            </div>


            @if (count($cotizacionActual) > 0)
                @php
                    $quoteByScales = false;
                @endphp
                @foreach ($cotizacionActual as $quote)
                    <div
                        class="flex justify-between border-t last:border-b border-gray-800 py-3 px-5 gap-2 items-center">
                        <div class="flex items-center">
                            <div style="width: 2rem">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <img src="{{ $quote->images_selected ?: ($quote->product->firstImage ? $quote->product->firstImage->image_url : asset('img/default.jpg')) }}"
                                    alt="" width="100">
                            </div>
                        </div>
                        <div class="flex-grow space-y-3">
                            <p class="font-bold text-lg">{{ $quote->product->name }}</p>
                            <div class="flex items-center space-x-3">
                                <p>Cantidad: <strong>{{ $quote->cantidad }}</strong> <span>PZ</span></p>
                                {{--        <input type="number" class="rounded-md border-gray-700 border text-center p-1 w-20"
                                    min="1" value="{{ $quote->cantidad }}"> --}}
                            </div>
                            {{-- <p>Costo de Personalizacion: <span class="font-bold"> $ {{ $quote->price_technique }}
                                    c/u</span> </p> --}}
                        </div>
                        <div class="h-full text-center">
                            @if ($quote->logo)
                                <img src="{{ asset('storage/logos/' . $quote->logo) }}" class="h-20 w-auto">
                            @else
                                <p class="text-center">Sin logo</p>
                            @endif
                        </div>
                        <div class="flex flex-col items-end space-y-2">

                            @php
                                $precioTotal = round(($quote->precio_total / ((100 - config('settings.utility_aditional')) / 100)) * 1.16, 2);
                            @endphp
                            <p class="font-bold text-lg">$ {{ number_format($precioTotal, 2, '.', ',') }}</p>
                            <button type="button" onclick='eliminar({{ $quote->id }})'
                                class="block w-full text-center text-sm underline rounded-sm font-semibold py-1 px-4">
                                Eliminar del carrito
                            </button>
                            {{-- {{ $quote }} --}}
                            @if (count($quote->haveSampleProduct($quote->product->id)) > 0)
                                @php
                                    // Obtener el id del proceso de muestra que viene en un array
                                    $sampleProcess = $quote->haveSampleProduct($quote->product->id)->toArray();
                                @endphp
                                <a href="{{ route('procesoMuestra', ['id' => $sampleProcess[0]['id']]) }}"
                                    class=" bg-[#662D91] text-white block w-full text-center text-sm underline rounded-sm font-semibold py-1 px-4">
                                    Ver Proceso
                                </a>
                                <button
                                    class="block w-full border-primary hover:border-primary-dark text-center rounded-sm font-semibold py-1 px-4"
                                    onclick="solicitarMuestra({{ $quote->id }})">
                                    Solicitar Muestra
                                </button>
                            @else
                                <button
                                    class="block w-full border-2 border-primary hover:border-primary-dark text-center rounded-sm font-semibold py-1 px-4"
                                    onclick="solicitarMuestra({{ $quote->id }})">
                                    Solicitar Muestra
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="sm:col-span-2 col-span-1">
            <div class="py-8 px-6">
                <p class="text-md py-3 text-center font-bold">RESUMEN DEL PEDIDO</p>
                <div class="px-8 space-y-3">
                    {{--                     <div class="flex justify-between">
                        <p>Subtotal:</p>
                        <p class="font-bold">$ {{ $totalQuote }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Costo de envio:</p>
                        <p class="font-bold">$ {{ $totalQuote }}</p>
                    </div>
                    <hr class="border-black"> --}}
                    <div class="flex justify-between">
                        <p>Total:</p>
                        @php
                            $total = round(($totalQuote / ((100 - config('settings.utility_aditional')) / 100)) * 1.16, 2);
                        @endphp
                        <p class="font-bold">$ {{ number_format($total, 2, '.', ',') }}</p>
                    </div>
                    <hr class="border-black">

                    <form wire:submit.prevent="generarPDF">
                        @csrf
                        @if(count($cotizacionActual) > 0)
                            <button type="submit" class="w-full bg-red-500 p-2 rounded text-center text-white" target="_blank" id="pdfButton" style="z-index:5;">
                                <div class="flex">
                                    <div class="flex-initial w-8">
                                        <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M378.413,0H208.297h-13.182L185.8,9.314L57.02,138.102l-9.314,9.314v13.176v265.514 c0,47.36,38.528,85.895,85.896,85.895h244.811c47.353,0,85.881-38.535,85.881-85.895V85.896C464.294,38.528,425.766,0,378.413,0z M432.497,426.105c0,29.877-24.214,54.091-54.084,54.091H133.602c-29.884,0-54.098-24.214-54.098-54.091V160.591h83.716 c24.885,0,45.077-20.178,45.077-45.07V31.804h170.116c29.87,0,54.084,24.214,54.084,54.092V426.105z"/> <path class="st0" d="M171.947,252.785h-28.529c-5.432,0-8.686,3.533-8.686,8.825v73.754c0,6.388,4.204,10.599,10.041,10.599 c5.711,0,9.914-4.21,9.914-10.599v-22.406c0-0.545,0.279-0.817,0.824-0.817h16.436c20.095,0,32.188-12.226,32.188-29.612 C204.136,264.871,192.182,252.785,171.947,252.785z M170.719,294.888h-15.208c-0.545,0-0.824-0.272-0.824-0.81v-23.23 c0-0.545,0.279-0.816,0.824-0.816h15.208c8.42,0,13.447,5.027,13.447,12.498C184.167,290,179.139,294.888,170.719,294.888z"/> <path class="st0" d="M250.191,252.785h-21.868c-5.432,0-8.686,3.533-8.686,8.825v74.843c0,5.3,3.253,8.693,8.686,8.693h21.868 c19.69,0,31.923-6.249,36.81-21.324c1.76-5.3,2.723-11.681,2.723-24.857c0-13.175-0.964-19.557-2.723-24.856 C282.113,259.034,269.881,252.785,250.191,252.785z M267.856,316.896c-2.318,7.331-8.965,10.459-18.21,10.459h-9.23 c-0.545,0-0.824-0.272-0.824-0.816v-55.146c0-0.545,0.279-0.817,0.824-0.817h9.23c9.245,0,15.892,3.128,18.21,10.46 c0.95,3.128,1.62,8.56,1.62,17.93C269.476,308.336,268.805,313.768,267.856,316.896z"/> <path class="st0" d="M361.167,252.785h-44.812c-5.432,0-8.7,3.533-8.7,8.825v73.754c0,6.388,4.218,10.599,10.055,10.599 c5.697,0,9.914-4.21,9.914-10.599v-26.351c0-0.538,0.265-0.81,0.81-0.81h26.086c5.837,0,9.23-3.532,9.23-8.56 c0-5.028-3.393-8.553-9.23-8.553h-26.086c-0.545,0-0.81-0.272-0.81-0.817v-19.425c0-0.545,0.265-0.816,0.81-0.816h32.733 c5.572,0,9.245-3.666,9.245-8.553C370.411,256.45,366.738,252.785,361.167,252.785z"/> </g> </g>
                                        </svg>
                                    </div>
                                    <div class="flex-initial">
                                        <span id="buttonText">GENERAR COTIZACIÓN</span>
                                    </div>
                                </div>
                            </button>
                            @if($pdfDescargado)

                            @endif
                            <div class="flex">
                            <iframe id="info" style="margin-left:-24px;margin-top:-24px; z-index:-1; display:none;" src="https://giphy.com/embed/3oEjI6SIIHBdRxXI40" width="100" height="100" frameBorder="0" class="giphy-embed" ></iframe>
                            <p id="info-text" style="margin-left:-20px; display:none;"  >Generando cotizacion, por favor espere</p>
                            </div>
                            

                        @endif
                    </form>

                    
                    {{-- <form action="{{ route('enviar-compra') }}" method="POST" class="col-start-2 col-span-4">
                        @method('POST')
                        @csrf
                        <button type="submit"
                            class="block w-full bg-primary hover:bg-primary-dark text-white text-center rounded-sm font-semibold py-2 px-4">
                            Enviar Carrito
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self
        class="hidden bg-slate-800 bg-opacity-50 justify-center items-center absolute top-0 right-0 bottom-0 left-0"
        id="modalSolicitarMuestra">
        <div class="bg-white px-16 py-6 rounded-sm text-center" style="width: 600px">
            <p class="text-xl mb-4 font-bold">Ingresa los datos para hacerte llegar la muestra</p>
            <div class="grid grid-cols-3 px-4">
                <div class="col-span-1 py-2 text-left">
                    <label for="nombre">Nombre: </label>
                </div>
                <div class="col-span-2 py-2 flex flex-col">
                    <input type="text" class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300"
                        wire:model="nombre">
                    @error('nombre')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 py-2 text-left">
                    <label for="telefono">Telefono: </label>
                </div>
                <div class="col-span-2 py-2">
                    <input type="text" class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300"
                        wire:model="telefono">
                    @error('telefono')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 py-2 text-left">
                    <label for="direcion">Direccion: </label>
                </div>
                <div class="col-span-2 py-2">
                    <textarea name="" id="" cols="10" rows="3"
                        class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300" wire:model="direccion"></textarea>
                    @error('direccion')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="px-3 py-1 text-md " onclick="closeModal()">Cancelar</button>
            <button class="px-5 py-1 ml-2 rounded-sm text-md text-white font-semibold bg-primary hover:bg-primary-dark"
                wire:click="solicitarMuestra">Enviar</button>
        </div>

    </div>
    <script>
        function solicitarMuestra(id) {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            @this.quote_id = id;
        }

        function closeModal() {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        window.addEventListener('muestraSolicitada', event => {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            Swal.fire({
                icon: event.detail.error ? "error" : "success",
                title: event.detail.msg,
                showConfirmButton: false,
                timer: 3000
            })
        })

        function eliminar(id) {
            Swal.fire({
                title: 'Esta seguro?',
                text: "Esta accion ya no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.eliminar(id)
                    Swal.fire(
                        'Eliminado!',
                        'El producto se ha eliminado.',
                        'success'
                    )
                }
            })
        }
    </script>
</div>
