$class = $this->util->slug($this->router->fetch_class());
$request_url = str_replace('/','',$_SERVER['REQUEST_URI']);
$current_url = PROTOCOL.$_SERVER['HTTP_HOST'].'/'.$request_url;