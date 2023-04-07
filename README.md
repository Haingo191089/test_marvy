- pull source về, bạn copy file .env.example thành file .env rồi sửa config DB trong .env
- mình có tạo file run_script.bat, bạn chạy file này để run app

Do có vài điểm trong requirement của bài test không rõ nên mình tự làm theo quan điểm cá nhân như sau:
- api api/user/register
    + Nếu trong DB tồn tại phone_number và name thì user cũ đăng nhập lại => trả về user_id
    + Nếu DB tồn tại phone_number nhưng name không trùng => báo lỗi "số phone đã được sử dụng"
    + nếu DB không tồn tại phone_number => user đăng ký mới
    + phone_number sẽ theo format bắt đầu là số 0 và có length là 10-11 chữ số
- api api/score/save
    + token sẽ theo thuật toán hash('sha256', "$userId::$gameId::$score::secret_key") với $userId, $gameId, $score là giá trị input của api
    + requirement có nói trong trường hợp hiếm sẽ có điểm > 500d nên mình không chặn max 500d
    + requirement có yêu cầu validate orgin request nên mình đã chặn, bạn có thể test bằng cách add/remove origin trong .env (tham khảo ALLOWED_ORIGIN trong .env.example)
- do có yêu cầu DDOS nên mình giới hạn 1 ip chỉ được gửi tối đa 5 request/phút

