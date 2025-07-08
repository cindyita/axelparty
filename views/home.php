<script src="./assets/js/form.js"></script>
<div class="py-2">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-xl w-full p-8" x-data="homeManager()" x-init="form.idguest = <?= $idInvite ?? 'null' ?>;">
      <div class="text-center font-bold text-xl animate__animated animate__fadeIn">
        <span><?= EVENT_SUBTITLE ?></span>
      </div>
      <div class="flex justify-center py-3 animate__animated animate__flipInY">
        <img src="./assets/img/title.png" alt="Mis 25 años Axel" class="logo">
      </div>

      <?php
        $start = date('Ymd', strtotime(EVENT_DAY));
        $end = date('Ymd', strtotime(EVENT_DAY . ' +1 day'));

        $googleUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE"
            . "&text=" . urlencode(EVENT_TITLE)
            . "&dates={$start}/{$end}"
            . "&details=" . urlencode(EVENT_DESCRIPTION)
            . "&location=" . urlencode(EVENT_LOCATION);
      ?>

      <div class="flex justify-center gap-5 p-2">
        <div class="flex flex-col justify-end items-end text-3xl letter-xl animate__animated animate__fadeInUp animate__delay-1s">
          <span>SÁB</span>
          <span>12 DE</span>
          <span class="flex gap-1 items-center"><span>JULIO</span> <a class="cursor-pointer group" target="_blank" href="<?= $googleUrl ?>" title="Agregar evento a calendar"><svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512"><path fill="#1e3050" class="group-hover:fill-teal-500 transition-colors duration-200" d="M96 32l0 32L48 64C21.5 64 0 85.5 0 112l0 48 448 0 0-48c0-26.5-21.5-48-48-48l-48 0 0-32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 32L160 64l0-32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192L0 192 0 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-272z"/></svg></a></span>
        </div>
        <div class="line animate__animated animate__fadeInUp animate__delay-1s"></div>
        <div class="flex flex-col justify-start items-start gap-2 animate__animated animate__fadeInUp animate__delay-2s">
          <span class="text-xl">4:00 PM</span>
          <span class="text-regular"><?= EVENT_LOCATION ?>
          <br />col. el sauz
          <br /><span class="flex gap-1 items-center"><span>guadalajara</span> <a class="cursor-pointer group" title="ver ubicación en google maps" href="<?= EVENT_URL_MAP ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><path fill="#1e3050" class="group-hover:fill-teal-500 transition-colors duration-200" d="M408 120c0 54.6-73.1 151.9-105.2 192c-7.7 9.6-22 9.6-29.6 0C241.1 271.9 168 174.6 168 120C168 53.7 221.7 0 288 0s120 53.7 120 120zm8 80.4c3.5-6.9 6.7-13.8 9.6-20.6c.5-1.2 1-2.5 1.5-3.7l116-46.4C558.9 123.4 576 135 576 152l0 270.8c0 9.8-6 18.6-15.1 22.3L416 503l0-302.6zM137.6 138.3c2.4 14.1 7.2 28.3 12.8 41.5c2.9 6.8 6.1 13.7 9.6 20.6l0 251.4L32.9 502.7C17.1 509 0 497.4 0 480.4L0 209.6c0-9.8 6-18.6 15.1-22.3l122.6-49zM327.8 332c13.9-17.4 35.7-45.7 56.2-77l0 249.3L192 449.4 192 255c20.5 31.3 42.3 59.6 56.2 77c20.5 25.6 59.1 25.6 79.6 0zM288 152a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg></a></span>
          </span>
        </div>
      </div>

      <div 
        x-data="countdown('<?= EVENT_DAY . 'T' . EVENT_START; ?>')" 
        x-init="startCountdown()" 
        class="text-center text-lg font-semibold text-gray-700 animate__animated animate__fadeInUp animate__delay-3s"
      >
        <div class="flex justify-center gap-4 text-2xl mt-4 flex-col md:flex-row">

          <div class="flex flex-col md:flex-row gap-4">
            <div class="rounded-full bg-yellow-300 py-2 px-4">
              <span x-text="days" class="text-2sl"></span>
              <div class="text-sm text-gray-500">días</div>
            </div>
            <div class="rounded-full bg-yellow-300 py-2 px-4">
              <span x-text="hours"> class="text-2sl"</span>
              <div class="text-sm text-gray-500">horas</div>
            </div>
          </div>

          <div class="flex flex-col md:flex-row gap-4">
            <div class="rounded-full bg-yellow-300 py-2 px-4">
              <span x-text="minutes" class="text-2sl"></span>
              <div class="text-sm text-gray-500">minutos</div>
            </div>
            <div class="rounded-full bg-yellow-300 py-2 px-4">
              <span x-text="seconds" class="text-2sl"></span>
              <div class="text-sm text-gray-500">segundos</div>
            </div>
          </div>
          
        </div>

      </div>

      <div class="animate__animated animate__fadeInUp animate__delay-3s">
        <p class="text-center text-md py-4"><?= EVENT_DESCRIPTION ?></p>
      </div>

      <div class="py-4 text-center w-full flex flex-col md:flex-row gap-5 items-center justify-center">
        <div class="flex gap-2 items-center animate__animated animate__delay-4s animate__flipInX">
          <span title="Vestimenta (dress code)">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="25" viewBox="0 0 640 512"><path class="fill-blue-400" d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0l12.6 0c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7 480 448c0 35.3-28.7 64-64 64l-192 0c-35.3 0-64-28.7-64-64l0-250.3-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0l12.6 0z"/></svg>
          </span>
          <span class="text-blue-400">Casual</span>
        </div>
        <div class="flex gap-2 items-center animate__animated animate__delay-4s animate__flipInX">
          <span title="Regalo">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><path class="fill-blue-400" d="M190.5 68.8L225.3 128l-1.3 0-72 0c-22.1 0-40-17.9-40-40s17.9-40 40-40l2.2 0c14.9 0 28.8 7.9 36.3 20.8zM64 88c0 14.4 3.5 28 9.6 40L32 128c-17.7 0-32 14.3-32 32l0 64c0 17.7 14.3 32 32 32l448 0c17.7 0 32-14.3 32-32l0-64c0-17.7-14.3-32-32-32l-41.6 0c6.1-12 9.6-25.6 9.6-40c0-48.6-39.4-88-88-88l-2.2 0c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41C215.7 16.9 186.1 0 154.2 0L152 0C103.4 0 64 39.4 64 88zm336 0c0 22.1-17.9 40-40 40l-72 0-1.3 0 34.8-59.2C329.1 55.9 342.9 48 357.8 48l2.2 0c22.1 0 40 17.9 40 40zM32 288l0 176c0 26.5 21.5 48 48 48l144 0 0-224L32 288zM288 512l144 0c26.5 0 48-21.5 48-48l0-176-192 0 0 224z"/></svg>
          </span>
          <span class="text-blue-400">Opcional</span>
        </div>
        <div class="flex gap-2 items-center animate__animated animate__delay-4s animate__flipInX">
          <span title="Invitados extra">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="25" viewBox="0 0 640 512"><path class="fill-blue-400" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
          </span>
          <span class="text-blue-400">Permitido</span>
        </div>
      </div>

      <hr class="border-2 my-4 border-blue-900 animate__animated animate__delay-5s animate__fadeIn" />

      <div class="text-center animate__animated animate__delay-5s animate__fadeIn">
        <h2 class="text-2xl mb-4">Registra tu asistencia:</h2>
        <form @submit.prevent="submitForm" class="max-w-md mx-auto py-3">

          <template x-if="loading">
              <div class="text-blue-600 text-center mb-2">Cargando..</div>
          </template>

        <template x-if="msg">
            <div class="text-green-600 text-center mb-2" x-text="msg"></div>
        </template>

        <template x-if="errors">
            <div class="text-red-600 text-center mb-2" x-text="errors"></div>
        </template>

          <div class="mb-4">
            <select
                x-model="form.idguest"
                class="input w-full border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                <?= $idInvite ? 'disabled' : '' ?>
              >
              <option hidden>Selecciona tu nombre</option>
                <?php foreach ($invites as $i): ?>
                  <option value="<?= $i['id'] ?>" ><?= $i['name'] ?></option>
                <?php endforeach; ?>
              </select>
          </div>

          <div class="mb-4">
            <textarea x-model="form.congrats"
              class="input w-full border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
              placeholder="Escribe una tarjeta de felicitaciones"></textarea>
          </div>

          <div class="flex gap-3 w-full flex-col md:flex-row">

            <div class="w-full">
              <select
                x-model="form.confirm"
                class="input w-full border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
              >
                <option value="Si">Voy a asistir</option>
                <option value="No">No voy a asistir</option>
                <option value="Tal vez">Aún no sé si asistiré</option>
              </select>
            </div>

            <div class="w-full md:w-1/4">
              <select
                x-model="form.extras"
                class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full" title="Invitados extras (Solo tu o tu+cuantos)"
              >
                <option value="0">Yo</option>
                <option value="1">+1</option>
                <option value="2">+2</option>
                <option value="3">+3</option>
              </select>
            </div>

            <button
              type="submit"
              class="button text-white rounded-full px-6 py-2 transition flex items-center gap-2">
              Confirmar
              <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25" viewBox="0 0 448 512"><path fill="#ffffff" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
            </button>

          </div>
          
        </form>

        <div class="mb-5">
          <a class="text-sm text-blue-800 hover:text-yellow-500 cursor-pointer" @click="requestModal.show()">
            No aparezco en la lista
          </a>
        </div>

      </div>

      <!----MODALS---->
      <div
          x-show="requestModal.open"
          @click.away="requestModal.open = false"
          @keydown.escape.window="requestModal.open = false"
          class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
          style="display: none;"
      >
          <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md relative">
              <button
              @click="requestModal.open = false"
              class="absolute top-0 right-3 text-gray-500 hover:text-red-500 text-3xl"
              >&times;</button>
              <h2 class="text-xl mb-4">Solicitud de invitación</h2>

              <template x-if="requestModal.errors">
                  <div class="text-red-600 text-center mb-2" x-text="requestModal.errors"></div>
              </template>

              <div>
                  <input
                      type="text"
                      x-model="requestModal.name"
                      class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                      placeholder="Nombre completo"
                      required
                  >
                  <input
                      type="text"
                      x-model="requestModal.contact"
                      class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                      placeholder="Teléfono o email"
                  >
              </div>

              <div class="flex justify-end gap-3">
              <button
                  @click="requestSend()"
                  class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2"
              >Enviar solicitud</button>
              </div>
              
          </div>
      </div>
      <!------------------------------>
      
    </div>
  </div>


  </div>