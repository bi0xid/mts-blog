<div style="text-align: center; background-color: #fff; color: #000; border: 1px solid #000; margin: 10px; padding: 10px; width: 400px;">
<p><strong style="font-size: 150%;"><?php echo wqp_escape_string($title); ?></strong></p>
<?php if (!empty($image)): ?>
<p><img src="<?php echo wqp_escape_string($image); ?>" alt="<?php echo wqp_escape_string($title); ?>" /></p>
<?php endif; ?>
<p><?php echo wqp_escape_string($desc); ?></p>
</div>

<div style="text-align: center;">
<p><strong style="font-size: 130%;">Share this quiz easily by copying the code below:</strong></p>
<p><textarea style="width: 100%; height: 400px;">
&lt;div style=&quot;text-align: center; background-color: #fff; color: #000; border: 1px solid #000; margin: 10px; padding: 10px; width: 400px;&quot;&gt;
&lt;p&gt;&lt;strong style=&quot;font-size: 150%;&quot;&gt;<?php echo wqp_escape_string($title); ?>&lt;/strong&gt;&lt;/p&gt;
<?php if (!empty($image)): ?>
&lt;p&gt;&lt;img src=&quot;<?php echo wqp_escape_string($image); ?>&quot; alt=&quot;<?php echo wqp_escape_string($title); ?>&quot; /&gt;&lt;/p&gt;
<?php endif; ?>
&lt;p&gt;<?php echo wqp_escape_string($desc); ?>&lt;/p&gt;
&lt;p&gt;&lt;a href=&quot;<?php echo $quiz_href; ?>&quot;&gt;<?php echo $quiz_title; ?>&lt;/a&gt;&lt;/p&gt;
&lt;/div&gt;
</textarea></p>
</div>