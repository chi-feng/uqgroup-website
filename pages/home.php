<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<h2>Introduction</h2>
    
<p>Welcome to the Uncertainty Quantification Group, in the <a href="http://aeroastro.mit.edu/">Department of Aeronautics and Astronautics</a> at <a href="http://mit.edu">MIT</a>. We are part of the <a href="http://acdl.mit.edu/">Aerospace Computational Design Laboratory</a> and affiliated with the <a href="http://computationalengineering.mit.edu/">Center for Computational Engineering</a>.</p>
    
<h3 id="research-overview">Research Overview</h2>

<p>Our research focuses on advancing fundamental computational methodology for uncertainty quantification and statistical inference in complex physical systems, and using these tools to address challenges in modeling energy conversion and environmental applications.</p>

<p>We tackle a broad range of projects, but most involve aspects of a few core questions:</p>

<ul class="bullets">
  <li>How to quantify confidence in computational predictions?</li> 
  <li>How to build or refine models of complex physical processes from indirect and limited observations?</li>
  <li>What information is needed to drive inference, design, and control?</li>
</ul>
    
<h3 class="noline">Recent Publications</h3>

<div class="articles">
<?php show_articles(array(20, 19, 18)); ?>
</div>

<div class="see-all">
  <a href="publications">Show all publications</a>
</div>

<script type="text/javascript" src="js/jquery.simplemodal.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    articlesAttachHover();
});
</script>
