<?php
Intratum\Facturas\Util::checkSession();
$title = "Hoja de contacto";
?>

<?php
$item = $_GET['item'];
$id2 = Intratum\Facturas\Util::getID2ByUUID("cust_",$item);
$customer = Intratum\Facturas\Customer::get($params = ["id2"=>$id2]);

Intratum\Facturas\Environment::$db->where('recipient_id', $customer["id"]);
Intratum\Facturas\Environment::$db->where('type', 1);

$custInvoices = Intratum\Facturas\Environment::$db->get('invoice');
?>

<div class="w-full flex items-center p-10">

    <div class="flex w-full flex-col border-[1px] bg-[#ffffff]">
        
        <div class="flex justify-around  p-5 gap-5 rounded-md ">

            <div class="flex gap-2">
                <div class="flex text-[35px] gap-1 mb-2 font-[700]"><h1><?=$customer["first_name"]?> <?php if ($customer["last_name"] != "") { ?> , <?=$customer["last_name"]?> <?php }?></h1></div>
                    <?php if ($customer["type"] == 'p') {?>
                            <div class="">
                                <h2 class=" font-[600] text-center bg-opacity-10 text-[15px] text-[#FF5F00] bg-[#ff7625] px-2 py-1 rounded-xl">Proveedor</h2>
                            </div>
                    <?php }else{?>
                            <div class=""><h2 class="font-[600] text-center bg-opacity-10 text-[#5AB2FF] bg-[#7ac1ff] px-2 py-1 rounded-xl">Cliente</h2></div>
                    <?php }?>
                </div>

                <div class="flex flex-col text-[20px] gap-1">
                    <div class="flex items-end gap-1"><svg width="25px" height="25px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.5 7V17C3.5 18.1046 4.39543 19 5.5 19H19.5C20.6046 19 21.5 18.1046 21.5 17V7C21.5 5.89543 20.6046 5 19.5 5H5.5C4.39543 5 3.5 5.89543 3.5 7Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.5 10H18.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15.5 13H18.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5 10C11.5 11.1046 10.6046 12 9.5 12C8.39543 12 7.5 11.1046 7.5 10C7.5 8.89543 8.39543 8 9.5 8C10.0304 8 10.5391 8.21071 10.9142 8.58579C11.2893 8.96086 11.5 9.46957 11.5 10Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M5.5 16C8.283 12.863 11.552 13.849 13.5 16" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg><h1><?=$customer["NIF"]?></h1></div>
                    <div class="flex items-end gap-1"><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 5.25L3 6V18L3.75 18.75H20.25L21 18V6L20.25 5.25H3.75ZM4.5 7.6955V17.25H19.5V7.69525L11.9999 14.5136L4.5 7.6955ZM18.3099 6.75H5.68986L11.9999 12.4864L18.3099 6.75Z" fill="#000000"></path> </g></svg><h1><?=$customer["email"]?></h1></div>
                    <div class="flex items-end gap-1"><svg width="25px" height="25px" viewBox="0 0 24 24" id="phone_number" data-name="phone number" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect id="Rectangle_5" data-name="Rectangle 5" width="24" height="24" fill="none"></rect> <path id="Shape" d="M7.02,15.976,5.746,13.381a.7.7,0,0,0-.579-.407l-1.032-.056a.662.662,0,0,1-.579-.437,9.327,9.327,0,0,1,0-6.5.662.662,0,0,1,.579-.437l1.032-.109a.7.7,0,0,0,.589-.394L7.03,2.446l.331-.662a.708.708,0,0,0,.07-.308.692.692,0,0,0-.179-.467A3,3,0,0,0,4.693.017l-.235.03L4.336.063A1.556,1.556,0,0,0,4.17.089l-.162.04C1.857.679.165,4.207,0,8.585V9.83c.165,4.372,1.857,7.9,4,8.483l.162.04a1.556,1.556,0,0,0,.165.026l.122.017.235.03a3,3,0,0,0,2.558-.993.692.692,0,0,0,.179-.467.708.708,0,0,0-.07-.308Z" transform="translate(4.393 6.587) rotate(-30)" fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="1.5"></path> </g></svg><h1><?=$customer["phone"]?></h1></div>
                </div>

                <div class="flex flex-col text-[20px] gap-1">
                    <div class="flex items-end gap-1"><svg fill="#000000" width="25px" height="25px" viewBox="0 0 16 16" id="world-16px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="Path_195" data-name="Path 195" d="M30,0a7.957,7.957,0,0,0-2.584.436.523.523,0,0,0-.1.037A7.978,7.978,0,1,0,30,0ZM23,8a7,7,0,0,1,4.473-6.52l1.344,1.106A.5.5,0,0,1,29,2.972V4.356a1.485,1.485,0,0,0-1.244-.135L26.025,4.8A1.5,1.5,0,0,0,25,6.221v.5a1.5,1.5,0,0,0,1.137,1.455L28,8.641a.5.5,0,0,1,.3.762l-1.045,1.568A1.493,1.493,0,0,0,27,11.8v2.512A7,7,0,0,1,23,8Zm4.961,6.695A.506.506,0,0,0,28,14.5V11.8a.5.5,0,0,1,.084-.278l1.045-1.567a1.5,1.5,0,0,0-.885-2.287L26.379,7.2A.5.5,0,0,1,26,6.719v-.5a.5.5,0,0,1,.342-.475l1.73-.576a.5.5,0,0,1,.512.121l.562.563A.5.5,0,0,0,30,5.5V2.972a1.5,1.5,0,0,0-.547-1.158l-.823-.677A6.978,6.978,0,0,1,35.84,4.15l-2.7.676A1.5,1.5,0,0,0,32,6.281v.6a1.491,1.491,0,0,0,.829,1.342l.73.364a.5.5,0,0,1,.261.569l-.667,2.672a1.5,1.5,0,0,0,.394,1.425l.47.47a6.963,6.963,0,0,1-6.056.971Zm6.833-1.608-.54-.54a.5.5,0,0,1-.131-.475L34.791,9.4a1.492,1.492,0,0,0-.785-1.705l-.73-.365A.5.5,0,0,1,33,6.882v-.6a.5.5,0,0,1,.379-.486l2.962-.74a6.948,6.948,0,0,1-1.547,8.032Z" transform="translate(-22)"></path> </g></svg><h1><?=$customer["country"]?></h1></div>
                    <div class="flex items-end gap-1"><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 21V22C18.5523 22 19 21.5523 19 21H18ZM6 21H5C5 21.5523 5.44772 22 6 22V21ZM17.454 3.10899L17 4L17.454 3.10899ZM17.891 3.54601L17 4L17.891 3.54601ZM6.54601 3.10899L7 4L6.54601 3.10899ZM6.10899 3.54601L7 4L6.10899 3.54601ZM9 6C8.44772 6 8 6.44772 8 7C8 7.55228 8.44772 8 9 8V6ZM10 8C10.5523 8 11 7.55228 11 7C11 6.44772 10.5523 6 10 6V8ZM9 9C8.44772 9 8 9.44772 8 10C8 10.5523 8.44772 11 9 11V9ZM10 11C10.5523 11 11 10.5523 11 10C11 9.44772 10.5523 9 10 9V11ZM14 9C13.4477 9 13 9.44772 13 10C13 10.5523 13.4477 11 14 11V9ZM15 11C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9V11ZM14 12C13.4477 12 13 12.4477 13 13C13 13.5523 13.4477 14 14 14V12ZM15 14C15.5523 14 16 13.5523 16 13C16 12.4477 15.5523 12 15 12V14ZM9 12C8.44772 12 8 12.4477 8 13C8 13.5523 8.44772 14 9 14V12ZM10 14C10.5523 14 11 13.5523 11 13C11 12.4477 10.5523 12 10 12V14ZM14 6C13.4477 6 13 6.44772 13 7C13 7.55228 13.4477 8 14 8V6ZM15 8C15.5523 8 16 7.55228 16 7C16 6.44772 15.5523 6 15 6V8ZM7.6 4H16.4V2H7.6V4ZM17 4.6V21H19V4.6H17ZM18 20H6V22H18V20ZM7 21V4.6H5V21H7ZM16.4 4C16.6965 4 16.8588 4.00078 16.9754 4.0103C17.0803 4.01887 17.0575 4.0293 17 4L17.908 2.21799C17.6366 2.07969 17.3668 2.03562 17.1382 2.01695C16.9213 1.99922 16.6635 2 16.4 2V4ZM19 4.6C19 4.33647 19.0008 4.07869 18.9831 3.86177C18.9644 3.63318 18.9203 3.36344 18.782 3.09202L17 4C16.9707 3.94249 16.9811 3.91972 16.9897 4.02463C16.9992 4.14122 17 4.30347 17 4.6H19ZM17 4L18.782 3.09202C18.5903 2.7157 18.2843 2.40973 17.908 2.21799L17 4ZM7.6 2C7.33647 2 7.07869 1.99922 6.86177 2.01695C6.63318 2.03562 6.36344 2.07969 6.09202 2.21799L7 4C6.94249 4.0293 6.91972 4.01887 7.02463 4.0103C7.14122 4.00078 7.30347 4 7.6 4V2ZM7 4.6C7 4.30347 7.00078 4.14122 7.0103 4.02463C7.01887 3.91972 7.0293 3.94249 7 4L5.21799 3.09202C5.07969 3.36344 5.03562 3.63318 5.01695 3.86177C4.99922 4.07869 5 4.33647 5 4.6H7ZM6.09202 2.21799C5.71569 2.40973 5.40973 2.71569 5.21799 3.09202L7 4L6.09202 2.21799ZM9 8H10V6H9V8ZM9 11H10V9H9V11ZM14 11H15V9H14V11ZM14 14H15V12H14V14ZM9 14H10V12H9V14ZM14 8H15V6H14V8ZM13 18V21H15V18H13ZM11 21V18H9V21H11ZM12 17C12.5523 17 13 17.4477 13 18H15C15 16.3431 13.6569 15 12 15V17ZM12 15C10.3431 15 9 16.3431 9 18H11C11 17.4477 11.4477 17 12 17V15Z" fill="#000000"></path> </g></svg><h1><?=$customer["state"]?>, <?=$customer["city"]?>, <?=$customer["zip"]?></h1></div>
                    <div class="flex items-end gap-1"><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.7 4.25C11.2858 4.24999 10.95 4.58577 10.95 4.99998C10.95 5.4142 11.2858 5.74999 11.7 5.75L11.7 4.25ZM13.5652 5.376L13.8555 4.68446L13.8552 4.68435L13.5652 5.376ZM15.7531 7.2L15.1268 7.61262L15.1272 7.6133L15.7531 7.2ZM16.575 9.94L17.325 9.94L17.325 9.93883L16.575 9.94ZM15.1466 13.433L14.536 12.9976C14.5271 13.01 14.5186 13.0228 14.5105 13.0357L15.1466 13.433ZM13.7309 15.7L13.0948 15.3027L13.0922 15.3069L13.7309 15.7ZM11.7 19L11.0617 19.3937C11.1983 19.6153 11.4401 19.7501 11.7004 19.75C11.9607 19.7499 12.2023 19.6148 12.3387 19.3931L11.7 19ZM9.66909 15.707L10.3075 15.3133L10.3055 15.3102L9.66909 15.707ZM8.25339 13.436L8.88985 13.0392C8.88178 13.0263 8.87332 13.0136 8.86447 13.0012L8.25339 13.436ZM6.82501 9.943L6.07501 9.94227V9.943H6.82501ZM7.64694 7.2L8.27278 7.6133L8.27282 7.61324L7.64694 7.2ZM9.83484 5.379L10.1247 6.07072L10.126 6.07018L9.83484 5.379ZM11.7011 5.75C12.1154 5.74937 12.4506 5.41308 12.45 4.99887C12.4494 4.58465 12.1131 4.24938 11.6989 4.25L11.7011 5.75ZM11.7 10.837C11.2858 10.837 10.95 11.1728 10.95 11.587C10.95 12.0012 11.2858 12.337 11.7 12.337V10.837ZM11.7 7.543C11.2858 7.543 10.95 7.87879 10.95 8.293C10.95 8.70721 11.2858 9.043 11.7 9.043L11.7 7.543ZM11.719 12.3428C12.133 12.3323 12.4602 11.9881 12.4498 11.574C12.4393 11.16 12.0951 10.8328 11.6811 10.8432L11.719 12.3428ZM10.2764 10.7817L10.927 10.4085L10.927 10.4085L10.2764 10.7817ZM10.2764 9.11131L9.62584 8.73812L9.62584 8.73812L10.2764 9.11131ZM11.6811 9.04976C12.0951 9.06023 12.4393 8.73303 12.4498 8.31895C12.4602 7.90487 12.133 7.56071 11.719 7.55024L11.6811 9.04976ZM11.7 5.75C12.2396 5.75001 12.7746 5.85774 13.2751 6.06765L13.8552 4.68435C13.1717 4.39771 12.4396 4.25002 11.7 4.25L11.7 5.75ZM13.2749 6.06754C14.0246 6.38224 14.6697 6.91882 15.1268 7.61262L16.3794 6.78738C15.761 5.84877 14.8836 5.11602 13.8555 4.68446L13.2749 6.06754ZM15.1272 7.6133C15.58 8.29886 15.8237 9.10956 15.825 9.94117L17.325 9.93883C17.3233 8.81655 16.9945 7.71889 16.3789 6.7867L15.1272 7.6133ZM15.825 9.94C15.825 10.5044 15.7399 10.9165 15.5556 11.3427C15.3608 11.7931 15.0461 12.2822 14.536 12.9976L15.7573 13.8684C16.269 13.1508 16.6684 12.5484 16.9324 11.9381C17.2068 11.3035 17.325 10.6856 17.325 9.94H15.825ZM14.5105 13.0357L13.0948 15.3027L14.3671 16.0973L15.7828 13.8303L14.5105 13.0357ZM13.0922 15.3069L11.0613 18.6069L12.3387 19.3931L14.3697 16.0931L13.0922 15.3069ZM12.3384 18.6063L10.3074 15.3133L9.03073 16.1007L11.0617 19.3937L12.3384 18.6063ZM10.3055 15.3102L8.88985 13.0392L7.61693 13.8328L9.03263 16.1038L10.3055 15.3102ZM8.86447 13.0012C8.35405 12.2838 8.03922 11.7947 7.84433 11.3444C7.66008 10.9186 7.57501 10.5073 7.57501 9.943H6.07501C6.07501 10.6887 6.19324 11.3059 6.46772 11.9401C6.73157 12.5498 7.13093 13.1522 7.6423 13.8708L8.86447 13.0012ZM7.57501 9.94373C7.57582 9.11123 7.81958 8.29958 8.27278 7.6133L7.02109 6.7867C6.40485 7.71986 6.0761 8.81882 6.07501 9.94227L7.57501 9.94373ZM8.27282 7.61324C8.73027 6.92039 9.37536 6.38473 10.1247 6.07072L9.54497 4.68728C8.51733 5.11791 7.63993 5.84942 7.02105 6.78676L8.27282 7.61324ZM10.126 6.07018C10.6264 5.8594 11.1613 5.75081 11.7011 5.75L11.6989 4.25C10.9591 4.25112 10.227 4.39999 9.54369 4.68782L10.126 6.07018ZM11.7 12.337C12.551 12.337 13.3277 11.8714 13.7443 11.1314L12.4371 10.3956C12.28 10.6748 11.9964 10.837 11.7 10.837V12.337ZM13.7443 11.1314C14.1597 10.3934 14.1597 9.4866 13.7443 8.7486L12.4371 9.4844C12.5954 9.76557 12.5954 10.1144 12.4371 10.3956L13.7443 11.1314ZM13.7443 8.7486C13.3277 8.00864 12.551 7.543 11.7 7.543L11.7 9.043C11.9964 9.043 12.28 9.2052 12.4371 9.4844L13.7443 8.7486ZM11.6811 10.8432C11.38 10.8508 11.0889 10.6908 10.927 10.4085L9.62584 11.1549C10.0553 11.9036 10.8541 12.3646 11.719 12.3428L11.6811 10.8432ZM10.927 10.4085C10.7638 10.1241 10.7638 9.76886 10.927 9.4845L9.62584 8.73812C9.19755 9.48474 9.19755 10.4083 9.62584 11.1549L10.927 10.4085ZM10.927 9.4845C11.0889 9.20225 11.38 9.04215 11.6811 9.04976L11.719 7.55024C10.8541 7.52838 10.0553 7.9894 9.62584 8.73812L10.927 9.4845Z" fill="#000000"></path> </g></svg><h1><?=$customer["address1"]?><?php if ($customer["address2"] != "") { ?> , <?=$customer["address2"]?> <?php }?></h1></div>    
                </div>

            </div>

            <div class="flex justify-end items-center mt-10 p-6 gap-5">

            
                <?php if ($customer["type"] == 'p') {?>
                    <a href="/proveedores/ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $customer["id2"]);?>" class="bg-[#40A578] text-white px-4 py-2 rounded-md">Editar</a>
                    <a href="/proveedores/del?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $customer["id2"]);?>" class="bg-[#FE0000] text-white px-4 py-2 rounded-md">Eliminar</a>
                <?php }else{?>
                    <a href="/clientes/ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $customer["id2"]);?>" class="bg-[#40A578] text-white px-4 py-2 rounded-md">Editar</a>
                    <a href="/clientes/del?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $customer["id2"]);?>" class="bg-[#FE0000] text-white px-4 py-2 rounded-md">Eliminar</a>
                <?php }?>



            </div>

        </div>

    </div>

    
<div class=" px-10">



<div class="w-full ">




<div class="mb-3 grid grid-cols-5 bg-[#ffffff] border-[1px] p-2 font-[700]">
    <h2>Nombre</h2>
    <h2>Número</h2>
    <h2>Fechas</h2>
    <h2>Estado</h2>
    <h2>Importe</h2>
    
    <h2></h2>
</div>

<?php

    foreach ($custInvoices as $i) {

        $db2 = Intratum\Facturas\Environment::$db;


        $db2->where('invoice_id', $i["id"] );
        $inv_settings = $db2->get('invoice_setting');
        
        $settings_2 = array_values(array_filter($inv_settings, function($item) {
            return $item['setting'] == 2;
        }));
        
        $settings_3 = array_values(array_filter($inv_settings, function($item) {
            return $item['setting'] == 3;
        }));
        
        $settings_4 = array_values(array_filter($inv_settings, function($item) {
            return $item['setting'] == 4;
        }));

        $is_paid = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($i["id"],$params = ["OPTION" => "PAYMENT_DATE",]);

        $is_recurring = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($i["id"],$params = ["OPTION" => "IS_RECURRING",]);


?>

    <div data-url="/facturas/ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="db_div bg-[#ffffff] border-[1px] mb-1 grid grid-cols-5 items-center p-2 rounded-xl">

        <h2 ><?= $i["first_name"]?></h2>
        <h2><?= $i["name"]?></h2>
        <h2><?= $i["invoice_date"]?></h2>

        <div>
          
            <?php if ($is_paid) {?>

                <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="rounded-xl flex items-center bg-[#effbf7] text-[#1dd2a2] opacity-80 p-2" type="button">
                    <p class="">Pagado</p>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                </button>

            <?php }else{ ?>

                <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="rounded-xl flex items-center bg-[#fff7ec] text-[#ffb145] opacity-80 p-2" type="button">
                    <p class="">Pendiente</p>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                </button>

            <?php } ?>


            <div id="dropdown<?=$i["id2"]?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">

                <ul class="py-1 text-md text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton<?=$i["id2"]?>">

                    <li class="border-l-4 border-[#1dd2a2]">
                        <button onclick="setPaid('<?=$i['id2']?>')" class="p-3 w-full hover:bg-[#effbf7]">Pagada</button>
                    </li>

                    <li class="border-l-4 border-[#ffb145]">
                        <button onclick="setUnPaid('<?=$i['id2']?>')" class="p-3 w-full hover:bg-[#fff7ec]">Pendiente</button>
                    </li>

                </ul>

            </div>


        </div>

        <div class="items-center grid grid-cols-2 gap-[50%]">

            <h2><?= $i["total"]/100?>€</h2>

            <div class="flex items-center gap-5">

                <button data-popover-target="popover-<?=$i['id2']?>" data-popover-placement="bottom" type="button" class="bg-blak">
                    <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M960 1468.235c93.448 0 169.412 75.965 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.447 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.447-75.964 169.412-169.412 169.412-93.448 0-169.412-75.965-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Z" fill-rule="evenodd"></path> </g></svg>
                </button>
                <?php if ($is_recurring) {?>
                    <svg data-popover-target="popover-info-<?=$i["id2"]?>" data-popover-placement="left" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7 1C6.44772 1 6 1.44772 6 2V3H5C3.34315 3 2 4.34315 2 6V20C2 21.6569 3.34315 23 5 23H13.101C12.5151 22.4259 12.0297 21.7496 11.6736 21H5C4.44772 21 4 20.5523 4 20V11H20V11.2899C20.7224 11.5049 21.396 11.8334 22 12.2547V6C22 4.34315 20.6569 3 19 3H18V2C18 1.44772 17.5523 1 17 1C16.4477 1 16 1.44772 16 2V3H8V2C8 1.44772 7.55228 1 7 1ZM16 6V5H8V6C8 6.55228 7.55228 7 7 7C6.44772 7 6 6.55228 6 6V5H5C4.44772 5 4 5.44772 4 6V9H20V6C20 5.44772 19.5523 5 19 5H18V6C18 6.55228 17.5523 7 17 7C16.4477 7 16 6.55228 16 6Z" fill="#0F0F0F"></path> <path d="M17 16C17 15.4477 17.4477 15 18 15C18.5523 15 19 15.4477 19 16V17.703L19.8801 18.583C20.2706 18.9736 20.2706 19.6067 19.8801 19.9973C19.4896 20.3878 18.8564 20.3878 18.4659 19.9973L17.2929 18.8243C17.0828 18.6142 16.9857 18.3338 17.0017 18.0588C17.0006 18.0393 17 18.0197 17 18V16Z" fill="#0F0F0F"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M24 18C24 21.3137 21.3137 24 18 24C14.6863 24 12 21.3137 12 18C12 14.6863 14.6863 12 18 12C21.3137 12 24 14.6863 24 18ZM13.9819 18C13.9819 20.2191 15.7809 22.0181 18 22.0181C20.2191 22.0181 22.0181 20.2191 22.0181 18C22.0181 15.7809 20.2191 13.9819 18 13.9819C15.7809 13.9819 13.9819 15.7809 13.9819 18Z" fill="#0F0F0F"></path> </g></svg>
                    <div data-popover id="popover-info-<?=$i["id2"]?>"  role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                        <p class=" py-2 px-4 text-black font-[600]">Esta factura ha sido generada</p>
                        <div data-popper-arrow></div>
                    </div>
                <?php }?>

                <div data-popover id="popover-<?=$i['id2']?>" role="tooltip" class="absolute z-10 invisible inline-block  text- text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="">
                        <ul class="p-2 flex flex-col justify-center items-center">

                            <li class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] rounded-md text-[#000000]">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#000000"></path> </g></svg>
                                <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="">Editar</a>    
                            </li>

                            <li class="w-full ">

                                <?php if ($i["invoice_state"] == 0) { ?>

                                    <button onclick="publicar('<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>')" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                        <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 2.5 2 C 2.0900381 2 1.6984009 2.1441855 1.421875 2.4199219 C 1.1453491 2.6956582 1 3.0876653 1 3.5 L 1 4.5 A 0.50005 0.50005 0 0 0 1.5 5 L 3 5 L 3 12.375 C 3 13.199669 3.6105159 14 4.5 14 L 7.7617188 14 C 8.5704696 15.204592 9.94479 16 11.5 16 C 13.979359 16 16 13.979359 16 11.5 C 16 9.5487862 14.741637 7.8970971 13 7.2753906 L 13 3.5 C 13 3.0876653 12.854651 2.6956582 12.578125 2.4199219 C 12.317203 2.1597448 11.952946 2.0211755 11.568359 2.0058594 A 0.50005 0.50005 0 0 0 11.5 2 L 2.5 2 z M 2.5 3 L 10.232422 3 C 10.144686 3.2093287 10 3.3950674 10 3.625 L 10 4 L 2 4 L 2 3.5 C 2 3.3093347 2.0551821 3.2024201 2.1289062 3.1289062 C 2.2026306 3.0553926 2.3109619 3 2.5 3 z M 11.5 3 C 11.689038 3 11.79737 3.0553932 11.871094 3.1289062 C 11.944818 3.2024201 12 3.3093347 12 3.5 L 12 7.0507812 C 11.833538 7.0319923 11.67136 7 11.5 7 C 10.439612 7 9.4752104 7.381117 8.7089844 8 L 5 8 L 5 9 L 7.7929688 9 C 7.5842039 9.3106797 7.4033096 9.6416499 7.2753906 10 L 5 10 L 5 11 L 7.0507812 11 C 7.0319923 11.166462 7 11.32864 7 11.5 C 7 12.028145 7.1071101 12.528582 7.2753906 13 L 4.5 13 C 4.1914841 13 4 12.756331 4 12.375 L 4 5 L 10.5 5 A 0.50005 0.50005 0 0 0 11 4.5 L 11 3.625 C 11 3.2436694 11.191484 3 11.5 3 z M 5 6 L 5 7 L 10 7 L 10 6 L 5 6 z M 11.5 8 C 13.438919 8 15 9.5610811 15 11.5 C 15 13.438919 13.438919 15 11.5 15 C 9.5610811 15 8 13.438919 8 11.5 C 8 9.5610811 9.5610811 8 11.5 8 z M 11 9 L 11 11 L 9 11 L 9 12 L 11 12 L 11 14 L 12 14 L 12 12 L 14 12 L 14 11 L 12 11 L 12 9 L 11 9 z"/></svg>
                                        <p class="text-[#000000]">Generar factura</p>
                                    </button> 

                                <?php }else{ ?>

                                    <a href="/pdf/<?= hash("sha256",$i["id2"]."50E7RQwnF050")?>.pdf" download class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                        <svg  width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>file_pdf [#000000]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-340.000000, -1279.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M303.7144,1125.149 L298.2594,1119.364 C298.0704,1119.165 297.8034,1119.001 297.5294,1119.001 L285.9794,1119.001 C284.8744,1119.001 284.0004,1120.001 284.0004,1121.105 L284.0004,1128.105 C284.0004,1128.657 284.4374,1129.001 284.9894,1129.001 L284.9944,1129.001 C285.5474,1129.001 286.0004,1128.657 286.0004,1128.105 L286.0004,1122.105 C286.0004,1121.553 286.4274,1121.001 286.9794,1121.001 L296.0004,1121.001 L296.0004,1125.105 C296.0004,1126.21 296.8744,1127.001 297.9794,1127.001 L302.0004,1127.001 L302.0004,1128.105 C302.0004,1128.657 302.4374,1129.001 302.9894,1129.001 L302.9944,1129.001 C303.5474,1129.001 304.0004,1128.657 304.0004,1128.105 L304.0004,1125.838 C304.0004,1125.581 303.8914,1125.335 303.7144,1125.149 L303.7144,1125.149 Z M287.9794,1134.105 C287.9794,1133.553 287.5314,1133.105 286.9794,1133.105 L285.9794,1133.105 L285.9794,1135.105 L286.9794,1135.105 C287.5314,1135.105 287.9794,1134.657 287.9794,1134.105 L287.9794,1134.105 Z M289.9754,1133.839 C290.0654,1135.569 288.6894,1137.001 286.9794,1137.001 L286.0004,1137.001 L286.0004,1138.105 C286.0004,1138.657 285.5474,1139.001 284.9944,1139.001 L284.9894,1139.001 C284.4374,1139.001 284.0004,1138.657 284.0004,1138.105 L284.0004,1132.105 C284.0004,1131.553 284.4274,1131.001 284.9794,1131.001 L286.8094,1131.001 C288.4344,1131.001 289.8904,1132.217 289.9754,1133.839 L289.9754,1133.839 Z M295.0004,1134.105 C295.0004,1133.553 294.5314,1133.001 293.9794,1133.001 L293.0004,1133.001 L293.0004,1137.001 L293.9794,1137.001 C294.5314,1137.001 295.0004,1136.657 295.0004,1136.105 L295.0004,1134.105 Z M297.0004,1134.001 L297.0004,1136.001 C297.0004,1137.651 295.6504,1139.001 294.0004,1139.001 L291.8954,1139.001 C291.4004,1139.001 291.0004,1138.6 291.0004,1138.105 L291.0004,1131.98 C291.0004,1131.439 291.4384,1131.001 291.9794,1131.001 L294.0004,1131.001 C295.6504,1131.001 297.0004,1132.351 297.0004,1134.001 L297.0004,1134.001 Z M304.0004,1132.027 L304.0004,1132.053 C304.0004,1132.605 303.5314,1133.001 302.9794,1133.001 L300.0004,1133.001 L300.0004,1135.001 L302.9794,1135.001 C303.5314,1135.001 304.0004,1135.474 304.0004,1136.027 L304.0004,1136.053 C304.0004,1136.605 303.5314,1137.001 302.9794,1137.001 L300.0004,1137.001 L300.0004,1138.105 C300.0004,1138.657 299.5474,1139.001 298.9944,1139.001 L298.9894,1139.001 C298.4374,1139.001 298.0004,1138.657 298.0004,1138.105 L298.0004,1132.105 C298.0004,1131.553 298.4274,1131.001 298.9794,1131.001 L302.9794,1131.001 C303.5314,1131.001 304.0004,1131.474 304.0004,1132.027 L304.0004,1132.027 Z" id="file_pdf-[#000000]"> </path> </g> </g> </g> </g></svg>
                                        <p>Descargar PDF</p>
                                    </a> 

                                    
                                    <a href="/pdf/<?= hash("sha256",$i["id2"]."50E7RQwnF050")?>.pdf" download class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.44 7.47h5.26v1.25H5.44zm0 2.36h5.26v1.25H5.44zm0-4.76h5.26v1.25H5.44z"></path><path d="M11.34 1 9.64.28 8.08 1 6.41.28 4.84 1 2.46 0v16l2.38-1 1.57.69L8.08 15l1.56.69 1.7-.69 2.2 1V0zm.94 13.11-.92-.41-1.69.69-1.57-.72-1.68.69-1.55-.69-1.15.47V1.86l1.15.47 1.55-.69 1.68.69 1.57-.69 1.69.69.92-.41z"></path></g></svg>
                                        <p>Descargar factura electrónica</p>
                                    </a> 

                                <?php }?> 

                                    

                                <?php if (!$is_recurring) {?>
                               
                                    <!-- Modal toggle -->
                                    <button data-modal-target="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" data-modal-toggle="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md" type="button">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 20H6C3.79086 20 2 18.2091 2 16V7C2 4.79086 3.79086 3 6 3H17C19.2091 3 21 4.79086 21 7V10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 2V4" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 2V4" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M2 8H21" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.5 15.6429L17 17.1429" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="17" cy="17" r="5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle> </g></svg>
                                        <p>Programar recurrencia</p>
                                    </button>
                                <?php }?> 

                                    


                                <a href="del?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#FE0000] rounded-md">
                                    <svg width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#FE0000" stroke="#FE0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#FE0000" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"></path></g></svg>
                                    <p>Eliminar</p>
                                </a> 


                            </li>

                        </ul>
                    </div>
                    <div class="place-self-end" data-popper-arrow></div>
                </div>  

            </div>
        </div>
    </div>




<!-- Main modal -->
<div id="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
<div class="relative p-4 w-full max-w-2xl max-h-full">


<div class="relative bg-white rounded-lg shadow-2xl dark:bg-gray-700 ">


                                            
<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h1 class="text-[20px] font-[600]">Programar recurrencia de <?=$i['name']?></h1>

        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
</div>

    <form id="form_<?=$i['id2']?>" class="recurring flex flex-col justify-center items-center p-10">
            <div class="p-5">
                <div class="flex mb-5 gap-5">
                    <div class="w-full flex items-center mb-4">
                        <input <?php if (empty($settings_2)) {?>checked <?php } ?> required  id="default-radio-0" type="radio" value="disabled" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-0" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Desactivado</label>
                    </div>

                    <div class="w-full flex items-center mb-4">
                        <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "1" ) {?> checked <?php } ?> id="default-radio-1" type="radio" value="weekly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Semanalmente</label>
                    </div>

                    <div class="w-full flex items-center mb-4">
                        <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "2" ) {?> checked <?php } ?> id="default-radio-2" type="radio" value="monthly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mensualmente</label>
                    </div>
                    <div class="w-full flex items-center mb-4">
                        <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "3" ) {?> checked <?php } ?> id="default-radio-3" type="radio" value="yearly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Anualmente</label>
                    </div>
                </div>

                <input type="hidden" name="id2" value="<?=$i['id2']?>">

                <div>
                    <div date-rangepicker class="flex items-center">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                           <input <?php if (!empty($settings_4) && $settings_4[0]["value"] != "" ) {?> value="<?php echo date("m-d-Y", strtotime( $settings_4[0]["value"] )) ?>" <?php } ?>   id="start_date" name="OPTION[REC_START_DATE]" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de inicio">

                        </div>

                        <span class="mx-4 text-gray-500 font-[700]">-</span>

                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input <?php if (!empty($settings_3) && $settings_3[0]["value"] != "" ) {?> value="<?php echo date("m-d-Y", strtotime( $settings_3[0]["value"] )) ?>"  <?php }else{ ?> value="ss" <?php } ?>    onchange="" id="end_date" name="OPTION[REC_END_DATE]" type="text" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de fin">
                        </div>
                    </div>
                </div>

                
                <div class="w-full flex justify-end items-end mt-10 ">
                    <button  class="bg-[#ECB176] text-[15px] px-3 py-1 rounded text-white" type="submit">Guardar</button>
                </div>

            </div>
        </form>
</div>
</div>
</div>

<?php }?>
</div>
</div>

    </div>

</div>




<script>

    $(document).ready(function() {
        $('[id^="modal-"]').each(function() {
            var modal = $(this);
            var radioDesactivado = modal.find('input[type="radio"][value="disabled"]');
            var fechaInicio = modal.find('#start_date');
            var fechaFin = modal.find('#end_date');

            function actualizarEstadoFecha() {
                var isDesactivado = radioDesactivado.is(':checked');
                fechaInicio.prop('disabled', isDesactivado).val(isDesactivado ? '' : fechaInicio.val());
                fechaFin.prop('disabled', isDesactivado).val(isDesactivado ? '' : fechaFin.val());

                if (isDesactivado) {
                    fechaInicio.addClass('pointer-events-none bg-gray-300');
                    fechaFin.addClass('pointer-events-none bg-gray-300');
                } else {
                    fechaInicio.removeClass('pointer-events-none bg-gray-300');
                    fechaFin.removeClass('pointer-events-none bg-gray-300');
                }
            }

            radioDesactivado.on('change', function() {
                actualizarEstadoFecha();
            });

            actualizarEstadoFecha();

            modal.find('input[type="radio"]').not(radioDesactivado).on('change', function() {
                if (!radioDesactivado.is(':checked')) {
                    fechaInicio.prop('disabled', false);
                    fechaFin.prop('disabled', false);
                    fechaInicio.removeClass('pointer-events-none bg-gray-300');
                    fechaFin.removeClass('pointer-events-none bg-gray-300');
                }
            });
        });
    });


    $(document).ready(function(){
        $('.db_div').on('dblclick', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            window.location.href = url;
        });


        $('.recurring').submit(function(e){
            e.preventDefault();

            var data = $(this).serializeJSON();

            options=[]


            Object.entries(data.OPTION).forEach(function([clave, valor]) {
                options.push({
                    "OPTION":clave,
                    "VALUE":valor
                });
            });

            newData = {
                "id2":data.id2,
                "OPTIONS":options
            }

            console.log(newData)


            $.ajax({

                type: 'POST',

                url: '/ajax/invoice_setting',

                dataType: 'json',

                contentType: 'application/json',

                data: JSON.stringify(newData),

                success: function(d) {

                    if (d["success"] == true) {
                        location.reload()
                    }

                }

            });

        });
    });

    function setPaid(id2){
        var timestamp = new Date().getTime();
        data = {
            "id2":id2,
            "OPTIONS":[{
                "OPTION":"PAYMENT_DATE",
                "VALUE":timestamp,
            }]
        }

        $.ajax({

            type: 'POST',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(data),

            success: function(d) {

                if (d["success"] == true) {
                    location.reload();
                }

            }

        });

    }

    function setUnPaid(id2){

      
        data = {
            "id2":id2,
            "OPTIONS":[{
                "OPTION":"PAYMENT_DATE",
                
            }]
        }

        $.ajax({

            type: 'DELETE',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(data),

            success: function(d) {

                if (d["success"] == true) {
                    window.location.href = '/facturas/';
                }

            }

        });

    }

    function convertDateFormat(date) {
        let dateParts = date.split('/');
        let year = dateParts[2];
        let month = dateParts[0].padStart(2, '0');
        let day = dateParts[1].padStart(2, '0');
        return `${year}${month}${day}`;
    }

    function buscar(){
        let busqueda = `?q=${$('#searchInput').val()}`
        let fecha_inicio = `start_date=${convertDateFormat($('#start_date').val())}`
        let fecha_final = `end_date=${convertDateFormat($('#end_date').val())}`

        window.location.href = busqueda+"&"+fecha_inicio+"&"+fecha_final;
    }

</script>