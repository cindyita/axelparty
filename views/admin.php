<script src="./assets/js/admin.js"></script>
<div class="p-7" x-data="guestManager()">
    <h1 class="text-2xl font-bold mb-4">Lista de invitados del evento: <?= $_ENV['EVENT_TITLE'] ?></h1>
    <div>
        <form @submit.prevent="enviar" class="mb-6">
            <div class="flex gap-3 flex-col md:flex-row">
                <input
                    type="text"
                    x-model="name"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                    placeholder="Nombre completo"
                    required
                >
                <div class="flex gap-2">
                    <input
                        type="text"
                        x-model="contact"
                        class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                        placeholder="Teléfono/email"
                    >
                    <select
                        x-model="active"
                        class="input w-full border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                    >
                        <option value="1">Invitado</option>
                        <option value="0">En espera</option>
                    </select>
                </div>
                
                <button
                    type="submit"
                    class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2">
                    Agregar
                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25" viewBox="0 0 448 512"><path fill="#ffffff" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                </button>
            </div>
        </form>
    </div>

    <template x-if="msg">
        <div class="text-green-600 text-center mb-2" x-text="msg"></div>
    </template>

    <template x-if="errors">
        <div class="text-red-600 text-center mb-2" x-text="errors"></div>
    </template>

    <template x-if="copyLink.msg">
        <div class="text-green-600 text-center mb-2" x-text="copyLink.msg"></div>
    </template>
    
    <div class="p-5 bg-white rounded-lg border border-blue-300">

        <div class="flex justify-between items-center">
            <div class="flex gap-2 items-center">
                <div>
                    <button @click="statsModal.show()" class="button-secondary text-white rounded-full px-4 transition flex items-center gap-2 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20"><path class="fill-white" d="M304 240l0-223.4c0-9 7-16.6 16-16.6C443.7 0 544 100.3 544 224c0 9-7.6 16-16.6 16L304 240zM32 272C32 150.7 122.1 50.3 239 34.3c9.2-1.3 17 6.1 17 15.4L256 288 412.5 444.5c6.7 6.7 6.2 17.7-1.5 23.1C371.8 495.6 323.8 512 272 512C139.5 512 32 404.6 32 272zm526.4 16c9.3 0 16.6 7.8 15.4 17c-7.7 55.9-34.6 105.6-73.9 142.3c-6 5.6-15.4 5.2-21.2-.7L320 288l238.4 0z"/></svg>
                    </button>
                </div>
                <div class="mt-3">
                    <input
                        type="text"
                        x-model="filter"
                        class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-3 py-2 text-sm mb-3 transition"
                        placeholder="Buscar.."
                        required
                    >
                </div>
            </div>
            <div>
                <button @click="exportTableToCSV('lista_invitados.csv','list-guests')" class="button-secondary text-white rounded-full px-4 transition py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20"><path class="fill-white" d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 144-208 0c-35.3 0-64 28.7-64 64l0 144-48 0c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM200 352l16 0c22.1 0 40 17.9 40 40l0 8c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-8c0-4.4-3.6-8-8-8l-16 0c-4.4 0-8 3.6-8 8l0 80c0 4.4 3.6 8 8 8l16 0c4.4 0 8-3.6 8-8l0-8c0-8.8 7.2-16 16-16s16 7.2 16 16l0 8c0 22.1-17.9 40-40 40l-16 0c-22.1 0-40-17.9-40-40l0-80c0-22.1 17.9-40 40-40zm133.1 0l34.9 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-34.9 0c-7.2 0-13.1 5.9-13.1 13.1c0 5.2 3 9.9 7.8 12l37.4 16.6c16.3 7.2 26.8 23.4 26.8 41.2c0 24.9-20.2 45.1-45.1 45.1L304 512c-8.8 0-16-7.2-16-16s7.2-16 16-16l42.9 0c7.2 0 13.1-5.9 13.1-13.1c0-5.2-3-9.9-7.8-12l-37.4-16.6c-16.3-7.2-26.8-23.4-26.8-41.2c0-24.9 20.2-45.1 45.1-45.1zm98.9 0c8.8 0 16 7.2 16 16l0 31.6c0 23 5.5 45.6 16 66c10.5-20.3 16-42.9 16-66l0-31.6c0-8.8 7.2-16 16-16s16 7.2 16 16l0 31.6c0 34.7-10.3 68.7-29.6 97.6l-5.1 7.7c-3 4.5-8 7.1-13.3 7.1s-10.3-2.7-13.3-7.1l-5.1-7.7c-19.3-28.9-29.6-62.9-29.6-97.6l0-31.6c0-8.8 7.2-16 16-16z"/></svg>
                </button>
            </div>
        </div>
        

        <div class="relative overflow-x-auto pb-2">
            <table class="w-full text-sm text-left rtl:text-right" id="list-guests">
                <thead class="text-xs uppercase">
                    <tr>
                        <th @click="sortBy('id')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Id <span class="text-lg text-teal-400" x-text="sortColumn != 'id' ? '↕' :(sortAsc ? '↑' : '↓')"></span>
                        </th>
                        <th @click="sortBy('name')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Nombre <span class="text-lg text-teal-400" x-text="sortColumn != 'name' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th @click="sortBy('contact')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Contacto <span class="text-lg text-teal-400" x-text="sortColumn != 'contact' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th @click="sortBy('confirm')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Confirmación <span class="text-lg text-teal-400" x-text="sortColumn != 'confirm' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th class="p-2 border border-blue-300 bg-teal-100">Felicitaciones</th>
                        <th class="py-1 px-2 border border-blue-300 bg-teal-100"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="guest in guestsFilter()" :key="guest.id">
                        <tr>
                            
                            <td class="p-2 md:table-cell font-medium border border-blue-300" :class="{ 'bg-red-200': !guest.active }" x-text="guest.id">
                            </td>
                            <td class="p-2 md:table-cell font-medium border border-blue-300" :class="{ 'bg-red-200': !guest.active }" :class="{ 'bg-red-200': !guest.active }" x-text="guest.name">
                            </td>
                            <td class="p-2 md:table-cell border border-blue-300" :class="{ 'bg-red-200': !guest.active }" x-text="guest.contact">
                            </td>
                            <td class="p-2 md:table-cell border border-blue-300" :class="{ 'bg-red-200': !guest.active }" x-text="guest.confirm">
                            </td>
                            <td
                            class="p-2 border border-blue-300 hover:underline"
                            :class="{ 'bg-red-200': !guest.active }"
                            >   
                                <span x-show="guest.congrats" @click="modal.show(guest.congrats, guest.name)" class="cursor-pointer alltext-shown">
                                    <span x-text="guest.congrats ? (guest.congrats.length > 24 ? guest.congrats.slice(0, 24) + '…' : guest.congrats) : ''"></span>
                                    <span class="text-teal-500 ml-1">[Ver más]</span>
                                </span>
                                <span class="alltext-hidden">
                                    <span x-text="guest.congrats"></span>
                                </span>
                            </td>
                            <td class="p-2 md:table-cell  font-medium border border-blue-300" :class="{ 'bg-red-200': !guest.active }">
                                <div class="flex gap-2 items-center">
                                    <a class="cursor-pointer group" @click="confirmModal.show('¿Eliminar a ' + guest.name + '?', () => deleteGuest(guest.id))">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                            <path
                                            fill="#6d9ecb"
                                            class="group-hover:fill-red-500 transition-colors duration-200"
                                            d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"
                                            />
                                        </svg>
                                    </a>

                                    <a x-show="guest.active" class="cursor-pointer group" @click="editModal.show(guest.id,guest.name,guest.contact)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 512 512"><path fill="#6d9ecb" class="group-hover:fill-yellow-500 transition-colors duration-200" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>

                                    <a x-show="guest.active" class="cursor-pointer group" @click="copyLink.copy(guest.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="25" viewBox="0 0 640 512"><path fill="#6d9ecb" class="group-hover:fill-teal-400 transition-colors duration-200" d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>
                                    </a>

                                    <a x-show="!guest.active">
                                        <button @click="invite(guest.id)" class="button-secondary text-white rounded-full px-3 transition flex items-center gap-2 py-1">Invitar</button>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <form method="get" action="logout">
            <button
                type="submit"
                class="button-secondary text-white rounded-full px-4 transition flex items-center gap-2 py-2">
                Cerrar sesión
            </button>
        </form>
    </div>

    <!----MODALS---->
    <div
        x-show="modal.open"
        @click.away="modal.open = false"
        @keydown.escape.window="modal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md relative mx-3">
            <button
            @click="modal.open = false"
            class="absolute top-0 right-3 text-gray-500 hover:text-red-500 text-3xl"
            >&times;</button>
            <h2 class="text-xl mb-4">🎉 Felicitación de <span x-text="modal.name"></span></h2>
            <p class="text-gray-800 whitespace-pre-line text-regular" x-text="modal.msg"></p>
        </div>
    </div>

    <div
        x-show="confirmModal.open"
        @click.away="confirmModal.open = false"
        @keydown.escape.window="confirmModal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm relative mx-3">
            <button
            @click="confirmModal.open = false"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl"
            >&times;</button>

            <h2 class="text-lg font-semibold text-gray-800 mb-3">¿Estás segur@?</h2>
            <p class="mb-5 text-gray-700" x-text="confirmModal.msg"></p>

            <div class="flex justify-end gap-3">
            <button
                @click="confirmModal.open = false"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2"
            >Cancelar</button>
            
            <button
                @click="confirmModal.confirmAction()"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2 bg-red-600 hover:bg-red-700"
            >Eliminar</button>
            </div>
        </div>
    </div>

    <div
        x-show="editModal.open"
        @click.away="editModal.open = false"
        @keydown.escape.window="editModal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm relative mx-3">
            <button
            @click="editModal.open = false"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl"
            >&times;</button>

            <h2 class="text-lg font-semibold text-gray-800 mb-3">Editar invitad@</h2>
            <div>
                <input
                    type="text"
                    x-model="editModal.name"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                    placeholder="Nombre completo"
                    required
                >
                <input
                    type="text"
                    x-model="editModal.contact"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                    placeholder="Teléfono/email"
                >
            </div>

            <div class="flex justify-end gap-3">
            <button
                @click="update()"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2"
            >Editar</button>
            </div>
        </div>
    </div>

    <div
        x-show="statsModal.open"
        @click.away="statsModal.open = false"
        @keydown.escape.window="statsModal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md relative mx-3">
            <button
            @click="statsModal.open = false"
            class="absolute top-0 right-3 text-gray-500 hover:text-red-500 text-3xl"
            >&times;</button>
            <h2 class="text-xl mb-4">Estadísticas</h2>
            <div>
                <table class="w-full text-sm text-left rtl:text-right">
                <tbody>
                    <tr>
                        <td>Total de invitados: <span class="text-teal-500" x-text="statsModal.stats.total_guests"></span></td>
                    </tr>
                    <tr>
                        <td>Total de confirmados: <span class="text-teal-500" x-text="statsModal.stats.total_confirm"></span></td>
                    </tr>
                    <tr>
                        <td>Total de confirmados "Si": <span class="text-teal-500" x-text="statsModal.stats.total_si"></span></td>
                    </tr>
                    <tr>
                        <td>Total de confirmados "No": <span class="text-teal-500" x-text="statsModal.stats.total_no"></span></td>
                    </tr>
                    <tr>
                        <td>Total de confirmados "Tal vez": <span class="text-teal-500" x-text="statsModal.stats.total_talvez"></span></td>
                    </tr>
                    <tr>
                        <td>Total de asistentes al evento (Considerando a los confirmados "Si" y sus extras): <span class="text-teal-500" x-text="statsModal.stats.total_attend"></span></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>



</div>

