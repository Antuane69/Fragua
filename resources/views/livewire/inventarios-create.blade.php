<div>
    <div id="preloader-livewire" wire:loading>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="my-4 px-4 py-3 ml-2 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('inventarios.inicio') }}"
                            class='w-auto bg-green-500 hover:bg-green-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Regresar
                        </a>
                    </div>
                </div>

                <form action="{{ route('inventarios.store') }}" method="post" id="formGuardar">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                            <input disabled name="rpe" value='{{ $datos->rpe }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <input name="rpe" value='{{ $datos->rpe }}' class="hidden" type="text" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NOMBRE:</label>
                            <input disabled name="nombre" value="{{$datos->paterno . " " . $datos->materno . ", " . $datos->nombre}}"
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-grey-700 focus:border-transparent"
                                type="text" required />
                            <input name="nombre" value="{{$datos->paterno . " " . $datos->materno . ", " . $datos->nombre}}" class="hidden" type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">EMAIL:</label>
                            <input disabled name="email" value='{{ $user->email }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <input name="email" value='{{ $user->email }}' class="hidden" type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Finalidad del pedido:</label>
                            <select name="proposito" @if($almacenSeleccionado == $subareaSeleccionada1) disabled @endif
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                <option value='1'>Almacenamiento</option>
                                <option @if($almacenSeleccionado == $subareaSeleccionada1) selected @endif value='0'>Consumo</option>
                                
                            </select>
                        </div>
                        @if (\Gloudemans\Shoppingcart\Facades\Cart::content()->count() == 0)
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                    ÁREA DEL ALMACEN AL QUE SE LE SOLICITA PRODUCTOS:
                                </label>
                                <select @if (Auth::user()->hasRole('usuario') || !(auth()->user()->datos->getArea == 'DX00')) disabled @endif name="area"
                                    value="$area->area_nombre" wire:model="areaSeleccionada"
                                    wire:change="actualizarSubareas"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                @foreach ($areas as $area)
                                    <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                        {{ $area->area_nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                    ALMACEN AL QUE SE LE SOLICITA PRODUCTOS:</label>

                                <select onchange="this.form.submit()" id="_almacen" name="almacen" value='$almacen->almacen_nombre' wire:model="almacenSeleccionado"
                                    wire:change="actualizarProductos"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 
                                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />

                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->almacen_clave }}">
                                            {{ $almacen->almacen_nombre }}
                                            -
                                            {{DB::table('datosusers')->where('rpe',$almacen->jefe_rpe)->value('nombre') . " " . DB::table('datosusers')->where('rpe',$almacen->jefe_rpe)->value('paterno') . " " . DB::table('datosusers')->where('rpe',$almacen->jefe_rpe)->value('materno')}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA DEL CENTRO DE TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <select @if (Auth::user()->hasRole('usuario') || !(auth()->user()->datos->getArea == 'DX00')) disabled @endif name="area1"
                                    value="$area1->area_nombre" wire:model="areaSeleccionada1"
                                    wire:change="actualizarSubareas1"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                @foreach ($areas1 as $area)
                                    <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                        {{ $area->area_nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO
                                    DE
                                    TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <select @if (Auth::user()->hasRole('usuario')) disabled @endif name="subarea"
                                    wire:model="subareaSeleccionada1" wire:change="cambioSubDestino" onchange="this.form.submit()"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 
                                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                    @foreach ($subareas1 as $subarea)
                                        <option id="{{ $subarea->subarea_clave }}" value="{{ $subarea->subarea_clave }}">
                                            {{ $subarea->subarea_nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                @else
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA DEL ALMACEN AL QUE SE LE SOLICITA:</label>
                        <select name="area"
                            style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2  mt-1  focus:ring-green-500 " type="text" required>
                            <option value="{{ $areaAux }}">
                                {{ App\Models\Area::find($areaAux)->area_nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                            ALMACEN AL QUE SE LE SOLICITA:</label>
                        <input name="almacen" value='{{ $subareaAux }}' class="hidden" type="text" />
                        <input disabled value='{{ App\Models\Subarea::find($subareaAux)->subarea_nombre }}'
                            style="border-color: rgb(21 128 61)"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" />
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA
                            DEL
                            CENTRO DE TRABAJO DONDE SE VA A ENTREGAR:</label>
                        <select name="area1" value="$area1->area_nombre" wire:model="areaSeleccionada1"
                            wire:change="actualizarSubareas1" style="background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @foreach ($areas1 as $area)
                                <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                    {{ $area->area_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO
                            DE
                            TRABAJO DONDE SE VA A ENTREGAR:</label>
                        <select name="subarea" value="$subarea1->subarea_nombre" wire:model="subareaSeleccionada1"
                            wire:change="cambioSubDestino" style="background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @foreach ($subareas1 as $subarea)
                                <option value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            @endif
            </form>
            <div class="my-4 px-4 py-3 mr-1 leading-normal text-blue-700 inline-flex-reverse" role="alert">
                <div class="inline-flex-reverse">
                    @if ($errors->any())
                        <div class="px-2 flex-row">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="px-2 inline-flex flex-row text-black" id="mssg-status">
                            {{ session()->get('message') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @elseif(session()->has('error'))
                        <div class="px-2 inline-flex flex-row py-1 text-black" id="mssg-status">
                            {{ session()->get('error') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <form action="{{ route('inventarios.pedidoespecial', [$areaSeleccionada1, $subareaSeleccionada1, $almacenSeleccionado]) }}"
                        id="formEspecial" class="place-content-center inline-flex rounded">
                            <button type="submit" class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">Pedido fuera de Catalogo</button>
                        </form>
                    </div>
                    <!-- Contador de productos en el carrito -->
                    <div class="px-2 flex flex-row-reverse">

                        <!-- Modal toggle -->
                        <div class="ml-4 bg-blue-600 rounded-lg">
                            <button
                                class="block openModal text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button" data-modal-toggle="defaultModal">
                                Ver carrito
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title"
                            role="dialog" aria-modal="true" id="interestModal">
                            <div
                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">​</span>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg @click="toggleModal" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 text-blue-600 place-self-center" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                    id="modal-title">
                                                    Productos en el carrito
                                                </h3>
                                                <div class="mt-2">
                                                    <ol class="text-sm text-gray-500">
                                                        @foreach ($carro as $item)
                                                            <li>
                                                                Producto: {{ $item->name }}
                                                                Cantidad: {{ $item->qty }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button onclick="guardarInventario()" type="button"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Guardar solicitud
                                        </button>
                                        <button type="button"
                                            class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        ({{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() }})
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        Carrito

                        {{-- @livewire('cart-counter') --}}
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                            style="padding-left: 2em; padding-right: 2em;">
                            <table id="data-table" class="stripe hover translate-table"
                                style="width:100%; padding-top: 1em; padding-bottom: 1em;" >
                                <thead>
                                    <tr>

                                        <th>NOMBRE DEL PRODUCTO</th>
                                        <th>TIPO DE UNIDAD</th>
                                        <th>CATEGORIA</th>
                                        <th>EXISTENCIAS</th>
                                        <th>FOTO</th>
                                        <th>CANTIDAD A PEDIR</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosA as $producto)
                                        <tr data-id="{{ $producto->id }}">
                                            <td>{{ $producto->nombre_prod }}</td>
                                            <td style="justify-items:center">{{ $producto->unidad }}</td>
                                            <td>{{ $producto->categoria->nombre_cat }}</td>
                                            <td>{{ $producto->existencias }}</td>
                                            <td>
                                                @if ($producto->photo_prod != null)
                                                    <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} "
                                                        width="50ppx" id="imagenSeleccionada"
                                                        alt="Foto actual del producto">
                                                @else
                                                    <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                                        width="50ppx" id="imagenSeleccionada"
                                                        alt="Foto actual del producto">
                                                @endif
                                            </td>

                                            <td class="border-l px-4 py-2">
                                                <div class="justify-center rounded-lg text-lg inline-flex">
                                                    @if ($carro->where('id', $producto->id)->count())
                                                        <form action="{{ route('cart.update') }}" method="POST"
                                                            enctype="multipart/form-data"
                                                            id="formCantidad{{ $producto->id }}"
                                                            class="place-content-center inline-flex rounded">
                                                            @csrf
                                                            <div>
                                                                <input type="hidden" name="row"
                                                                    value="{{ $carro->where('id', $producto->id) }}" />
                                                                <input type="number" name="cantidad"
                                                                    placeholder="Cantidad"
                                                                    class="rounded-lg text-sm sm:test-base ml-4 pr-4 w-2/3"
                                                                    value="{{ $carro[$producto->id]->qty }}"
                                                                    min="1" required />
                                                            </div>
                                                            <div class="rounded bg-blue-600 hover:bg-blue-700 mr-4">
                                                                <button type="submit"
                                                                    class="rounded text-white font-bold py-1 px-1 inline-flex">Cambiar
                                                                    cantidad
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pr-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <!-- botón borrar -->
                                                        <form action="{{ route('cart.destroy') }}" method="POST"
                                                            id="formEliminar{{ $producto->id }}">
                                                            @csrf
                                                            <input type="hidden" name="row"
                                                                value="{{ $carro->where('id', $producto->id) }}" />
                                                            <div class="rounded bg-red-600 hover:bg-red-600 mr-4">
                                                                <button type="submit"
                                                                    class="rounded  text-white font-bold py-1 px-1 inline-flex">Borrar
                                                                    del carrito
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pr-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <!-- botón agregar al carrito -->
                                                        <form action="{{ route('cart.store') }}" method="POST"
                                                            enctype="multipart/form-data"
                                                            id="formAgregar{{ $producto->id }}"
                                                            class="place-content-center inline-flex rounded">
                                                            @csrf
                                                            <div>
                                                                <input type="hidden" name="producto_id"
                                                                    value="{{ $producto->id }}" />
                                                                <input type="number" name="cantidad"
                                                                    placeholder="Cantidad"
                                                                    class="rounded-lg text-sm sm:test-base m-1 pr-1 w-8/12"
                                                                    min="1" required />
                                                                <input type="hidden" name="subareaDestino"
                                                                    wire:model="subDestino" />
                                                                <input type="hidden" name="almacen"
                                                                    value="{{ $almacenSeleccionado }}" />
                                                            </div>
                                                            <div class="rounded bg-green-500 hover:bg-green-700">
                                                                <button type="submit"
                                                                    class="rounded text-white font-bold py-1 inline-flex w-11/12">Agregar
                                                                    al carrito
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pl-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        {{-- @livewire('inventarios-table') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
