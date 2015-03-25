<?php
$template = Template::getInstance();
$template->title = 'Software';
$template->tab = 'Software';
?>

<h2>Software</h2>

<h3>MIT Uncertainty Quantification (MUQ) Library</h3>
<p>MUQ is a collection of tools for constructing models and a collection of UQ-orientated algorithms for working on those model.  Our goal is to provide an easy and clean way to set up and efficiently solve uncertainty quantification problems.</p>
<p><a class="btn" href="https://bitbucket.org/mituq/muq">Download from Bitbucket</a></p>

<h3>GPEXP: Experimental Design for Gaussian Process Regression in Python</h3>
<p>GPEXP is a software package, written in python2.7, for performing
experimental design in the context of GP regression. Experimental design
may be performed for a variety of cost function specifications.
Currently supported cost functions include those based on integrated
variance, conditional entropy, and mutual information. GPEXP may also be
used for general purpose GP regression. Currently supported kernels
include the isotropic and anisotropic squared exponential kernel, the
isotropic Matern kernel, and the Mehler kernel. Additional kernels may
be easily specified. GPEXP also includes optimization routines for
estimating kernel hyperparameters from data.</p>
<p><a class="btn" href="https://github.com/goroda/GPEXP">Download from Github</a></p>

<h3>NOWPAC (Nonlinear Optimization With Path-Augmented Constraints)</h3>
<p>NOWPAC is a software package for derivative-free nonlinear constrained local optimization. The code is based on a trust region framework using surrogates of minimum Frobenius norm type for the objective function and the constraints. The code does not require gradient information and is designed to work with only black-box evaluations of the objective function and the constraints. In addition to the optimization procedure, NOWPAC provides a noise detection tool which identifies inaccurate black-box evaluations that might corrupt the optimal result or prevent the optimization procedure from making further progress.</p>
<p><a class="btn" href="https://bitbucket.org/fmaugust/nowpac">Download from Bitbucket</a></p>
<h4>Related Publications</h4>
<div class="articles">
<?php $articles = json_decode(file_get_contents('json/articles.json'), true); show_articles(array(29)); ?> 
</div>

<!-- include to interact with publication display -->
<script type="text/javascript" src="js/jquery.simplemodal.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    articlesAttachHover();
});
</script>
