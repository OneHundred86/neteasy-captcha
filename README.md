##### 一、功能说明

易盾行为验证码校验，用于laravel框架。

如果验证码校验异常出错，会在laravel日志文件记录错误信息。

##### 二、安装

```shell
composer require "oh86/netesay-captcha"
```

##### 三、配置

1. 添加下面一行到 `config/app.php` 中 `providers` 部分：

   ```
   Oh86\NetEasy\Captcha\CaptchaProvider::class,
   ```

2. 发布配置文件与资源

   ```
   php artisan vendor:publish --provider='Oh86\NetEasy\Captcha\CaptchaProvider'
   ```

3. 配置.env

   ```
   NETEASY_SECRET_ID=
   NETEASY_SECRET_KEY=
   NETEASY_CAPTCHA_ID=
   ```

4. 校验验证码
   ```php
   use Oh86\NetEasy\Captcha\Facade\CaptchaVerify;
   CaptchaVerify::verify('CN31_26SIlYVCJAEkcFMPU_5dJbZQHNwnYAbdLBUV8-DuPFY_rxecR.mfDufJdy5dP0P-uBUdwy4fYwwMLhGqJRunbr6H-yoTwXey9MRjZ81buapfcg8qwhzaanpufToTi-KCGq0AeSiA9dN7syixFUFmnMUi8Br870YJqNSmlzrrKRVWlhHGTmhUX9BPV5EqCyg4nB6eBPdpG5T4TV00s_uyTnbuBkUBhWqK-7DM8hwJ-ea.16of7X99yQvYG8vPmnFT9vM5QjKu5aKAYGDwS9wL.o8d88XVBum06tWiRujnCjIBT7rko2dhVfen6bUFbGefyyhiCL7NLJ_sdx_qU76UZ0vPAYkZtFFEVRKHtNAxHI_lqvPG4mWqOU1ftK6v7_UFMQkc4Gw5H5WIFAwwwViKlCAQHedutYYUUCAF8zp5SCMh1dI77NLiJ6sUlo1qOe1anz6mFmgJYczKscJeeKsVz6lBm5nlgaGUjgPNBhWkLBTA6v79iH4gTE_GHWN3');
   ```