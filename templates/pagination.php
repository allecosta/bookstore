<?php

$totPages = $listProducts->totalPages();

if ($totPages > 1) : ?>
    <ul id="pagination" class="nav justify-content-center">
        <?php
        
        for ($i = 1; $i <= $totPages; $i++) : ?>
            <li class="nav-item">
                <a class="nav-link" 
                    href="?search=<?php echo clear($_GET['search']); ?>&page=<?php echo $i; ?>"><?php echo $i; ?>
                </a>
            </li>
        <?php endfor ?>
    </ul>
<?php endif ?>



