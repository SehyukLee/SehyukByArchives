<?php
class userModel extends CI_Model {
    function insertUserData($userData) {
        // 사용자 등록 모델

        $insert_id           =      $userData['id'];            // 등록 할 유저 아이디
        $insert_classifi     =      $userData['classifi'];     // 등록 할 유저 직업
        $insert_name         =      $userData['name'];          // 등록 할 유저 이름
        $insert_gender       =      $userData['gender'];        // 등록 할 유저 성별
        $insert_passwd       =      $userData['passwd'];        // 등록 할 유저 비밀번호
        $insert_phone        =      $userData['phone'];         // 등록 할 유저 전화번호
        $insert_email        =      $userData['email'];         // 등록 할 유저 이메일

        $is_id = $this->db->query("select count(sysid) from userinfo where userid='$insert_id'");
        // 아이디 검사

        if(!$is_id) {
            // 아이디 검사 실패 시

            return false;
        }

        $is_id_re = $is_id->result_array();
        // 아이디 검사 결과 배열로 저장

        if($is_id_re[0]['count(sysid)'] > 0) {
            // 등록 할 아이디와 똑같은 아이디가 있을 경우

            return $insert_id;
        }
        else {
            // 등록 할 아이디와 똑같은 아이디가 없을 경우

            $query = $this->db->query("insert into userinfo values('', '$insert_id', '$insert_classifi', '$insert_name', '$insert_gender', '$insert_passwd', '$insert_phone', '$insert_email');");
            // 사용자 등록

            if($query) {
                // 등록 완료 시

                return true;
            }
            else {
                // 등록 실패 시

                return false;
            }
        }
    }

    function updateUserData($userData) {
        // 사용자 정보수정 모델

        $update_id           =      $userData['userid'];            // 수정 할 유저 아이디
        $update_classifi     =      $userData['classification'];   // 수정 할 유저 직업
        $update_name         =      $userData['name'];              // 수정 할 유저 이름
        $update_gender       =      $userData['gender'];            // 수정 할 유저 성별
        $update_passwd       =      $userData['password'];          // 수정 할 유저 비밀번호
        $update_phone        =      $userData['phone'];             // 수정 할 유저 전화번호
        $update_email        =      $userData['email'];             // 수정 할 유저 이메일

        $query = $this->db->query("update userinfo set classification='$update_classifi', name='$update_name', gender='$update_gender', password='$update_passwd', phone='$update_phone', email='$update_email' where userid='$update_id';");
        // 사용자 정보수정

        if($query) {
            // 수정 완료 시

            return true;
        }
        else {
            // 수정 실패 시

            return false;
        }
    }

    function findUser($input_id) {
        // 유저 아이디 검색 모델

        $query = $this->db->query("select * from userinfo where userid='$input_id'");
        // 아이디 검색

        if(!$query) {
            // 검색 실패 시

            return false;
        }

        $query_re = $query->result_array();     // 검사 결과 값을 배열로 저장

        if(count($query_re) > 0) {
            // 검색한 아이디가 있을 경우

            return $query_re[0];
        }
        else {
            // 검색한 아이디가 없을 경우

            return $input_id;
        }
    }

    function deleteUserData($delete_id, $delete_pass) {
        // 사용자 삭제 모델

        $is_id = $this->db->query("select count(sysid), password from userinfo where userid='$delete_id'");
        // 아이다, 비밀번호 검색

        if(!$is_id) {
            // 검색 실패 시

            return false;
        }

        $is_id_re = $is_id->result_array();     // 검색 결과 배열로 저장

        if($is_id_re[0]['count(sysid)'] == 0) {
            // 아이디가 없을 경우

            return $delete_id;
        }
        else {
            // 아이디가 있을 경우

           if($is_id_re[0]['password'] == $delete_pass) {
               // 비밀번호가 맞을 경우

               $query = $this->db->query("delete from userinfo where userid='$delete_id'");
               // 사용자 삭제

               if($query) {
                   // 삭제 완료 시

                   return true;
               }
               else {
                   // 삭제 실패 시

                   return false;
               }
           }
           else {
               // 비밀번호가 틀린 경우

               return $delete_pass;
           }
        }
    }

    function get_count_all($table="userinfo") {
        // 해당 테이블의 전체 행 수 출력 모델

        return $this->db->count_all($table);
    }

    function selectUserData($start = 0, $end = 0) {
        // 전체 회원보기 모델

        $table = "userinfo";    // 회원 정보 테이블 명

        if($end != 0) {
            // 페이지 수가 0이 아닌 경우

            $limit = " limit ".$start.", ".$end; // 페이지네이션 설정
        }
        else {
            $limit = "";
        }

        $sql = "select * from ".$table." order by sysid desc ".$limit;
        // 전체 회원 정보 검색 쿼리문

        $query = $this->db->query($sql);    // 전체 회원 정보 검색
        $result = $query->result();         // 검색 결과

        return $result;
    }
}
?>