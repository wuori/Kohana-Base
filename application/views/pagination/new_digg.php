<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Digg pagination style
 * Updated to use LI's by Wuori
 * 
 * @preview  Ç Previous  1 2 É 5 6 7 8 9 10 11 12 13 14 É 25 26  Next È
 */
?>

<ul class="pagination">

	<?php if ($previous_page): ?>
		<li><a href="<?php echo str_replace('{page}', $previous_page, $url) ?>">&laquo;</a></li>
	<?php else: ?>
		<li>&laquo;</li>
	<?php endif ?>


	<?php if ($total_pages < 13): /* Ç Previous  1 2 3 4 5 6 7 8 9 10 11 12  Next È */ ?>

		<?php for ($i = 1; $i <= $total_pages; $i++): ?>
			<?php if ($i == $current_page): ?>
				<li class="current"><?php echo $i ?></li>
			<?php else: ?>
				<li><a href="<?php echo str_replace('{page}', $i, $url) ?>"><?php echo $i ?></a></li>
			<?php endif ?>
		<?php endfor ?>

	<?php elseif ($current_page < 9): /* Ç Previous  1 2 3 4 5 6 7 8 9 10 É 25 26  Next È */ ?>

		<?php for ($i = 1; $i <= 10; $i++): ?>
			<?php if ($i == $current_page): ?>
				<li class="current"><?php echo $i ?></li>
			<?php else: ?>
				<li><a href="<?php echo str_replace('{page}', $i, $url) ?>"><?php echo $i ?></a>
			<?php endif ?>
		<?php endfor ?>

		<li>&hellip;</li>
		<li><a href="<?php echo str_replace('{page}', $total_pages - 1, $url) ?>"><?php echo $total_pages - 1 ?></a>
		<li><a href="<?php echo str_replace('{page}', $total_pages, $url) ?>"><?php echo $total_pages ?></a>

	<?php elseif ($current_page > $total_pages - 8): /* Ç Previous  1 2 É 17 18 19 20 21 22 23 24 25 26  Next È */ ?>

		<li><a href="<?php echo str_replace('{page}', 1, $url) ?>">1</a></li>
		<li><a href="<?php echo str_replace('{page}', 2, $url) ?>">2</a></li>
		<li>&hellip;</li>

		<?php for ($i = $total_pages - 9; $i <= $total_pages; $i++): ?>
			<?php if ($i == $current_page): ?>
				<li class="current"><?php echo $i ?></li>
			<?php else: ?>
				<li><a href="<?php echo str_replace('{page}', $i, $url) ?>"><?php echo $i ?></a></li>
			<?php endif ?>
		<?php endfor ?>

	<?php else: /* Ç Previous  1 2 É 5 6 7 8 9 10 11 12 13 14 É 25 26  Next È */ ?>

		<li><a href="<?php echo str_replace('{page}', 1, $url) ?>">1</a></li>
		<li><a href="<?php echo str_replace('{page}', 2, $url) ?>">2</a></li>
		<li>&hellip;</li>

		<?php for ($i = $current_page - 5; $i <= $current_page + 2; $i++): ?>
			<?php if ($i == $current_page): ?>
				<li class="current"><?php echo $i ?></li>
			<?php else: ?>
				<li><a href="<?php echo str_replace('{page}', $i, $url) ?>"><?php echo $i ?></a></li>
			<?php endif ?>
		<?php endfor ?>

		<li>&hellip;</li>
		<li><a href="<?php echo str_replace('{page}', $total_pages - 1, $url) ?>"><?php echo $total_pages - 1 ?></a></li>
		<li><a href="<?php echo str_replace('{page}', $total_pages, $url) ?>"><?php echo $total_pages ?></a></li>

	<?php endif ?>


	<?php if ($next_page): ?>
		<li><a href="<?php echo str_replace('{page}', $next_page, $url) ?>">&raquo;</a></li>
	<?php else: ?>
		<li>&raquo;</li>
	<?php endif ?>

</ul>