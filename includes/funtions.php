<!-- Các hàm chung -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layouts($layoutName, $data=[]) {
    if(file_exists(_WEB_PATH_TEMPLATES . '/layout/'. $layoutName. '.php')) {
        require_once _WEB_PATH_TEMPLATES . '/layout/'. $layoutName. '.php';
    }
}

// Hàm gửi mail 
function sendMail($to, $subject, $content) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'cskhbandl@gmail.com';                     //SMTP username
        $mail->Password   = '@12345678@';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $content;

        $mail->send();
        echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Kiểm tra phương thức GET
function isGet() {
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// Kiểm tra phương thức POST
function isPost() {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

function filter() {
    $filterArr = [];
    if(isGet()) {
        // Xử lý dữ liệu trước khi hiển thị ra 
        // return $_GET;
        if(!empty($_GET)) {
            foreach($_GET as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    if(isPost()) {
        // Xử lý dữ liệu trước khi hiển thị ra 
        // return $_POST;
        if(!empty($_POST)) {
            foreach($_POST as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    return $filterArr;
}

