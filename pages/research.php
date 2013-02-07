<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<h2>Research Areas</h2>

<h3>Optimal Bayesian Experimental Design</h3>
<div class="blurb">
  <p>Not all experiments are created equal, some are more valuable than others. Performing experiments under conditions that maximize the value of data thus would lead to substantial resource savings. We develop a general mathematical framework and an algorithmic approach for optimal experimental design with nonlinear simulation-based models; in particular, we focus on finding sets of experiments that provide the most information about targeted sets of model parameters.</p>
  <div class="figure">
    <img src="images/research/optexp.png" width="750" height="210" />
    <p class="caption">The posterior for design A shows the most &ldquo;confident&rdquo; posterior, reflecting its highest expected utility value.</p>
  </div>
  <h4>Further Reading</h4>
  <div class="articles">
  <?php show_articles(array(20)); ?>
  </div>
</div>

<h3>Bayesian Inversion using Optimal Maps (MCMC-free)</h3>
<div class="blurb">
  <p>By reinterpreting Bayesian inversion as a transformation from the prior random variable to the posterior random variable, we have developed an efficient, exact optimization algorithm to compute the map (without Markov chains). Advantages include error measures and conversions criteria, which enable analytic computation of posterior statistics, efficient propagation of posterior knowledge, parallelizable, evidence computed for free.</p>
  <div class="figure">
    <img src="images/research/optmap.png" width="750" height="295" />
    <p class="caption col-1-2">Comparing results obtained with the map (thick contours) against results obtained with MCMC (thin contours), for a fixed set of contour levels.</p>
    <p class="caption col-2-2">Boxplot of Karhunen-Loève mode weights, obtained with the map. Superimposed are posterior means obtained with the map and with MCMC, along with truth values of the weights.</p>
  </div>
  <h4>Further Reading</h4>
  <div class="articles">
  <?php show_articles(array(19)); ?>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  articlesAttachHover();
});
</script>