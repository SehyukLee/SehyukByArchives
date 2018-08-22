<?php
class mainController extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->database();             // DB 연결
        $this->load->model("userModel");    // 해당 모델 객체 생성

        $this->load->helper('url');          // URL 헬퍼 로딩
        $this->load->library('pagination'); // 페이지네이션 라이브러리 로딩
    }

    function index() {
        // 첫 화면

        $adress = array("insert"    =>      "./mainController/showUserInsert",
                        "update"     =>      "./mainController/showUserUpdate",
                        "delete"     =>      "./mainController/showUserDelete",
                        "select"     =>      "./mainController/showUserSelect");
        // 주소 값 지정

        $this->load->view("mainView", $adress); // 메인 뷰 호출
    }

    function showUserInsert() {
        // 사용자 등록 뷰 호출 함수

        $this->load->view("showInsert");    // 사용자 등록 뷰 호출
    }

    function showUserUpdate() {
        // 사용자 정보수정 뷰 호출 함수

        $this->load->view("showUpdate");    // 사용자 정보수정 뷰 호출
    }

    function showUserDelete() {
        // 사용자 삭제 뷰 호출 함수

        $this->load->view("showDelete");    // 사용자 삭제 뷰 호출
    }

    function showUserSelect() {
        // 전체 회원보기

        $config['base_url']      = base_url('index.php/mainController/showUserSelect');  // 페이지네이션 url 설정
        $config['total_rows']    = $this->userModel->get_count_all();                            // 전체 행 수
        $config['per_page']      = 5;                                                             // 한 페이지에서 보여줄 행 수
        $config['uri_segment']   = 3;                                                             // 페이지번호 URL위치 지정

        $this->pagination->initialize($config);                     // 페이지네이션 설정 초기화
        $data['pagination'] = $this->pagination->create_links();   // 페이지네이션 저장

        $page = $this->uri->segment(3, 0);                           // URL의 3번째 값 추출

        $data['list'] = $this->userModel->selectUserData($page, $config['per_page']);
        // 유저 리스트

        $this->load->view("showSelect", $data); // 전체 회원보기 뷰 호출
    }

    function userInsert() {
        // 사용자 등록

        $trueOrFalse = true;    // 유효성 결과

        $input_userData = array("id"        =>      $this->input->post("userid"),
                                "classifi"  =>      $this->input->post("classification"),
                                "name"       =>     $this->input->post("username"),
                                "gender"     =>     $this->input->post("gender"),
                                "passwd"     =>     $this->input->post("userpassword"),
                                "phone"      =>     $this->input->post("phone"),
                                "email"      =>     $this->input->post("email"));
        // 입력 한 값

        foreach($input_userData as $value) {
            if(!$value) {
                echo "전부 입력해 주십시오.";
                $this->load->view("reShowInsert", $input_userData);
                $trueOrFalse = false;
                break;
            }
        }
        // 유효성 검사

        if($trueOrFalse) {
            $insert = $this->userModel->insertUserData($input_userData);
            // 유저 등록

            $adress = array("insert"    =>      "./showUserInsert",
                            "update"     =>     "./showUserUpdate",
                            "delete"     =>     "./showUserDelete",
                            "select"     =>     "./showUserSelect");
            // 주소 값 지정

            if($insert === $input_userData["id"])  {
                // 같은 아이디의 유저가 있을 경우

                echo "이미 있는 아이디 입니다.";
                $this->load->view("reShowInsert", $input_userData);
            }
            elseif($insert) {
                // 등록 완료 시

                echo "등록완료<br>";
                $this->load->view("mainView", $adress);
            }
            else {
                // 등록 실패 시

                echo "query send failed";
                $this->load->view("mainView", $adress);
            }
        }
    }

    function userUpdate($disabled_id) {
        // 사용자 정보수정

        $trueOrFalse = true;    // 유효성 결과

        $input_userData = array("userid"            =>     $disabled_id,
                                "classification"    =>     $this->input->post("classification"),
                                "name"               =>     $this->input->post("username"),
                                "gender"             =>     $this->input->post("gender"),
                                "password"           =>     $this->input->post("userpassword"),
                                "phone"              =>     $this->input->post("phone"),
                                "email"              =>     $this->input->post("email"));
        // 입력 한 값

        foreach($input_userData as $value) {
            if(!$value) {
                echo "전부 입력해 주십시오.";
                $this->load->view("reShowUpdate", $input_userData);
                $trueOrFalse = false;
                break;
            }
        }
        // 유효성 검사

        if($trueOrFalse) {
            $update = $this->userModel->updateUserData($input_userData);    // 유저 정보 업데이트

            $adress = array("insert"    =>      "./showUserInsert",
                            "update"     =>     "./showUserUpdate",
                            "delete"     =>     "./showUserDelete",
                            "select"     =>     "./showUserSelect");
            // 주소 값 지정

            if($update) {
                // 수정 완료 시

                $adress = array("insert"    =>      "../showUserInsert",
                                "update"    =>      "../showUserUpdate",
                                "delete"    =>      "../showUserDelete",
                                "select"    =>      "../showUserSelect");
                // 주소 값 지정

                echo "수정완료<br>";
                $this->load->view("mainView", $adress);
            }
            else {
                // 수정 실패 시

                echo "query send failed";
                $this->load->view("mainView", $adress);
            }
        }
    }

    function userDelete() {
        // 사용자 삭제

        $input_id['delete_id']     = $this->input->post("user_id");     // 입력한 유저 아이디
        $input_pass['delete_pass'] = $this->input->post("user_pass");   // 입력한 유저 비밀번호

        $adress = array("insert"    =>      "./showUserInsert",
                        "update"     =>      "./showUserUpdate",
                        "delete"     =>      "./showUserDelete",
                        "select"     =>      "./showUserSelect");
        // 주소 값 지정

        $delete = $this->userModel->deleteUserData($input_id['delete_id'], $input_pass['delete_pass']);
        // 사용자 삭제

        if($delete === $input_id['delete_id']) {
            // 입력한 아이디가 없을 경우

            echo "없는 아이디 입니다.";
            $this->load->view("showDelete");
        }
        elseif($delete === $input_pass['delete_pass']) {
            // 입력한 아이디는 있지만 비밀번호가 맞지 않을 경우

            echo "비밀번호가 맞지 않습니다.";
            $this->load->view("showDelete");
        }
        elseif($delete === true) {
            // 삭제 완료 시

            echo "삭제 완료<br>";
            $this->load->view("mainView", $adress);
        }
        else {
            // 삭제 실패 시

            echo "query send failed";
            $this->load->view("mainView", $adress);
        }
    }

    function userIdFind() {
        // 유저 아이디 검색

        $findUser_id["find_id"] = $this->input->post("ckeckId");    // 입력한 유저 아이디

        if($findUser_id["find_id"]) {
            $findResult = $this->userModel->findUser($findUser_id["find_id"]);
            // 해당 아이디를 가진 유저 검색

            if(!$findResult) {
                // 검색 실패 시

                echo "query send failed";
                $this->load->view("showUpdate");
            }
            elseif($findResult == $findUser_id["find_id"]) {
                // 해당 아이디가 없을 경우

                echo $findUser_id["find_id"]."이란 아이디는 없습니다.";
                $this->load->view("showUpdate");
            }
            else {
                // 해당 아이디가 있을 경우

                $this->load->view("reShowUpdate", $findResult);
            }
        }
        else {
            $this->load->view("showUpdate");
        }
    }
}
?>