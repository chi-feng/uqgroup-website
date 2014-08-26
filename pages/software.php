<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<!--
<div id="breadcrumbs">
  <a href="home">UQ Group</a> <i class="icon-angle-right"></i>
  <a href="software">Software</a>
</div>
-->

<h2>Software</h2>

<h3 class="noline">
MIT Uncertainty Quantification (MUQ) Library
</h3>
<p>In a nutshell, MUQ is a collection of tools for constructing models and a collection of UQ-orientated algorithms for working on those model.  Our goal is to provide an easy and clean way to set up and efficiently solve uncertainty quantification problems.  On the modelling side, we have a suite of tools for:</p>
<ol>
<li>Combing many simple model components into a single sophisticated model.</li>
<li>Propagating derivative information through sophisticated models.</li>
<li>Solving systems of partial differential equations (via LibMesh)</li>
<li>Integrating ordinary differential equations and differential algebraic equations (via Sundials)</li>
</ol>
<p>Furthermore, on the algorithmic side, we have tools for</p>
<ol>
<li>Performing Markov chain Monte Carlo (MCMC) sampling</li>
<li>Constructing polynomial chaos expansions (PCE)</li>
<li>Computing Karhunen-Loeve expansions</li>
<li>Building optimal transport maps</li>
<li>Solving nonlinear constrained optimization problems (both internally and through NLOPT)</li>
<li>Solving robust optimization problems</li>
<li>Regression (including Gaussian process regression)</li>
</ol>
<p>Check out the source code on <a class="" href="https://bitbucket.org/mituq/muq" target="_blank">BitBucket <i class="icon-external-link"></i></a>

