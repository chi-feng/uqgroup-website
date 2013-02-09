<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<!--
<div id="breadcrumbs">
  <a href="home">UQ Group</a> <i class="icon-angle-right"></i>
  <a href="software">Software</a>
</div>
-->

<h2>Software</h2>

<h3>
MIT Uncertainty Quantification (MUQ) Library
</h3>

<p><a class="btn" href="https://bitbucket.org/mituq/muq" target="_blank">
  BitBucket Repository &nbsp; <i class="icon-external-link"></i> </a></p>

<p>
This library is a product of MIT's UQ lab, led by Youssef Marzouk. In time, we 
hope to provide a collection of UQ tools, reflecting the research of the lab. 
This initial release includes only a polynomial chaos library. It is separate 
from our working repository and the history is currently hidden - we hope to 
change this in the future. For now, we will only post stable releases.
</p>

<p>
We have attempted to write these libraries in modern C++ style, using the new 
C++11 standard, Boost, Eigen, and other utility libraries. 
</p>

<p>
Currently this library is available under the LGPLv2. Please contact us if you 
have other requirements and we may be able to work something out.
</p>

<p>
We would appreciate feedback on whether this effort is useful to others. We 
aren't currently set up to handle user contributions, but if collaborators 
would like to provide improvements, that would likely try to support that 
effort. We will strive to support prospective users, but as students, our time 
is naturally limited.
</p>

<h3>Polychaos</h3>

<p>
We believe this implements the state of the art in non-intrusive construction 
of polynomial chaos expansions. We believe it will be useful for three reasons.
</p>
<ol>
<li>This implementation is state of the art. Although it does require a few 
  steps to install, the API is light-weight and flexible. Crucially, it does 
  not require expertise to elicit good performance due to the adaptive nature 
  of the algorithm.</li>
<li>It is a companion to the paper below. We haven't included the actual 
  examples from that paper, but anyone attempting to understand or replicate 
  these features can use this implementation as a reference.</li>
<li>Beyond pseudospectral technqiues, we have implemented a general framework 
  for adaptive Smolyak algorithms. Included are both quadrature and 
  pseudspectral specializations. We have also toyed with an FMM approximation 
  idea, which didn't work out, but which was facilitated by the re-use of the 
  book-keeping code provided here.</li>
</ol>
<p>
This work is published as the following paper. We would appreciate a citation 
of this paper, as appropriate.
</p>
<p>
Conrad, Patrick R., Marzouk, Youssef M. &ldquo;Adaptive Smolyak Pseudospectral 
Approximations.&rdquo; (2012). Submitted to SIAM Journal on Scientific 
Computing.
</p>
<p>
See the <a href="https://bitbucket.org/mituq/muq/wiki/Home">wiki</a> for some 
more information on installation and getting started.
</p>