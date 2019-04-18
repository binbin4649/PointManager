<?php echo $Pmpage['company_name'] ?> 御中


いつもお世話になっております。
<?php echo $mailConfig['site_name'] ?> です。

今月のご利用料金が規定未満でしたので、請求は次月に繰越させていただきます。
よろしくお願い申し上げます。

【繰越内容】
締め日：<?php echo $Pmtotal['yyyymm']."\n" ?>
合計：<?php echo number_format($Pmtotal['total']) ?>円

※明細は、マイページ「ポイント履歴」からCSVがダウンロードできますので、そちらでご確認お願いいたします。

---
　<?php echo $mailConfig['site_name'] ?>　
　<?php echo $mailConfig['site_url'] ?>　
　Mail:<?php echo $mailConfig['site_email'] ?>　