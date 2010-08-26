<?php defined('_JEXEC') or die('Restricted access'); ?>

<img src="<?php echo $this->image->getLarge()->getUrl(); ?>" width="<?php echo $this->image->getLarge()->getWidth(); ?>" height="<?php echo $this->image->getLarge()->getHeight(); ?>" alt="<?php echo $heading; ?>" />

<h2><?php echo $this->album->getTitle(); ?></h2>

<h1><?php echo $this->image->getTitle(); ?></h1>

<?php if ($this->image->getCaption()) { ?>
<p class="caption">
	<?php $this->image->getCaption(); ?>
</p>
<?php } ?>

<?php if ($this->image->getDescription()) { ?>
<p><?php echo $this->image->getDescription(); ?></p>
<?php } ?>
