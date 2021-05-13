## Cài đặt môi trường Docker cho dự án job-board
  <p>3.1. Pull code</p>
  <pre><code>git clone ssh://gituser@jawhm.net:8822/var/lib/git/repository/jobboard.git</code></pre> 
  <p>3.2. Di chuyển vào thư mục jobboard</p>
  <pre><code>cd jobboard</code></pre>    
  <p>3.3. Cập nhật wp-config.php</p>
  <pre><code>
   	define('DB_NAME', 'kotanglish');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'abc123');
	define('DB_HOST', 'db');
  </code></pre>
  <p>3.4. Tạo file docker-compose.yml với nội dung bên dưới<p>
  
  <pre><code>
    version: "3.3"
services:
    app:
        ports:
            - 8084:80
        image: "plutonianbe/php54-apache:latest"
        container_name: jobboard
        volumes:
            - ./:/var/www/html
        networks:
            - network_nginx_proxy
            - network_2
        restart: always
        environment: 
            VIRTUAL_HOST: "local.jobboard"
networks:
    network_nginx_proxy:
        external: 
            name: nginx-proxy
    network_2:
        external: 
            name: dbshared
  </code></pre>
  
  
  <p>Sau đó khởi động container bằng lệnh</p>
  <pre><code>docker-compose up -d</code></pre>
  
  - Tiếp theo chúng ta cấu hình file hosts. Bạn mở file hosts nằm trong thư mục có đường dẫn sau:
<pre><code>C:\Windows\System32\drivers\etc.</code></pre>
- Nhập nội dung <code>192.168.1.99 local.kotanglish</code> vào cuối file host và lưu lại.
<i><b>Lưu ý:</b> Thay đổi dịa chỉ ip <code>192.168.1.99</code> bằng địa chỉ ip server của bạn</i>
<p>Lúc này từ trình duyệt ở máy host, có thể truy cập đến Webserver máy ảo bằng địa chỉ <code>local.kotanglish</code>.</p>

