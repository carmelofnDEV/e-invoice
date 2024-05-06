<section class="bg-white dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center  mt-10 mx-auto  lg:py-0">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/static/logo.png" class="h-8" alt="Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">e-Invoice</span>
        </a>
        <div class="w-full bg-gray rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Registrate!
                </h1>
                <form id="form" class="space-y-4 md:space-y-6" action="#">
                    <div >
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu correo</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="correo@email.com" required="">


                            <ul class="error_list" id="div_email">

                            </ul>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">

                            <ul class="error_list" id="div_password">

                            </ul>

                    </div>

                    <div >
                        <label for="repeat_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Repetir Contraseña</label>
                        <input type="password" name="repeat_password" id="repeat_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                        
                            <ul class="error_list" id="div_repeat_password">

                            </ul>

                    </div>

                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="first_name" name="first_name" id="first_name" placeholder="Tu nombre aquí" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                        <input type="last_name" name="last_name" id="last_name" placeholder="Tus apellidos aquí" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500 dark:text-gray-300">Acepto los<a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="/terminos-y-condiciones/"> terminos y condiciones</a></label>
                        </div>
                    </div>
                    <div id="error-message" class="text-red-500"></div>

                    <div class="g-recaptcha" data-sitekey="6LfmCqwpAAAAAJMZOpuaSyba77TytuEm6QpzDEj1"></div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        ¿Ya tienes cuenta? <a href="/login/" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
class Invoices{


    static checkValiate(form, response, callback){

        $('.error_list').empty()

        if(response != null){

            response.forEach(error => {
                $('#div_'+error.params).append('<li class="text-[#ff0000]">'+error.message+'</li>');
                console.log(`Param: ${error.params}, Message: ${error.message}`);
            });
        }else{
            callback();
        }
    }
}
</script>
<script>
    $(document).ready(function() {
        $('#form').submit(function(e) {
            e.preventDefault();

            var data = $(this).serializeJSON();
            console.log(data);
            


            $.ajax({
                type: 'POST',
                url: '/ajax/user',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    console.log(response)

                    Invoices.checkValiate($('#form'),response, function(){
                        window.location.href = "/empresa/";
                    });

                },
                error: function() {
                    $('#error-message').text('Hubo un error al procesar la solicitud').show();
                }
            });


        });
    });
</script>