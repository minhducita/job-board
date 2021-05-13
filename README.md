## Cài đặt môi trường Docker cho dự án job-board
  <p>1. Pull code</p>
  <pre><code>git clone ssh://gituser@jawhm.net:8822/var/lib/git/repository/jobboard.git</code></pre> 
  <p>2. Tạo file config.envs.php</p>
  <pre><code>cp config.envs-example.php config.envs.php</code></pre>    
  <p>3. Cập nhật config.envs.php</p>
  <pre><code>
  	// should be a unique part of the url (or the entire url if you wish)
	'prefix' => 'local.jobboard',
	'db_host' => 'db',
	'db_port' => 3306,
	'db_user' => 'root', 
	'db_password' => 'abc123',
	'db_name' => 'jobboard',
	// your site's full url
	'app_url' => 'http://local.jobboard/',
  </code></pre>
  
  <p>4. Tạo file docker-compose.yml với nội dung bên dưới<p>
  
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
- Nhập nội dung <code>192.168.1.99 local.jobboard</code> vào cuối file host và lưu lại.
<i><b>Lưu ý:</b> Thay đổi dịa chỉ ip <code>192.168.1.99</code> bằng địa chỉ ip server của bạn</i>
<p>Cập nhật lại setting domain trong database của bạn ở table kg_options</p>
<pre><code>
	siteurl	= http://kotanglish.bluecloudvn.com
	home	= http://kotanglish.bluecloudvn.com
</code></pre>
<p>Lúc này từ trình duyệt ở máy host, có thể truy cập đến Webserver máy ảo bằng địa chỉ <code>local.jobboard</code>.</p> 
<p>Truy cập vào trang quản trị: http://local.jobboard/admin/ với User/Pass tương ứng trong database của bạn.</p>
