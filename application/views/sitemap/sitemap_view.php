<div id="sitemap-page">
	<ul>
	    <li>
	        <?=anchor('/', $this->lang->line('page_main'))?>
	        <ul>
	        	<li>
	        		<?=$this->lang->line('page_about')?>
		        	<ul>
		        		<li><?=anchor('/about/history', $this->lang->line('page_history'))?></li>
		        		<li><?=$this->lang->line('activity')?>
			        		<ul>
			        			<li>
			        				<?=$this->lang->line('page_education_index')?>
				        			<ul>
				        				<li><?=anchor('/about/education',$this->lang->line('page_education_general'))?></li>
				        				<li><?=anchor('/about/education/bachelor',$this->lang->line('page_education_bachelor'))?></li>
				        				<li><?=anchor('/about/education/magistracy',$this->lang->line('page_education_magistracy'))?></li>
				        				<li><?=anchor('/about/education/pgdoc',$this->lang->line('page_education_pgdoc'))?></li>
				        			</ul>
			        			</li>
			        			<li>
			        				<?=$this->lang->line('page_scientific_index')?>
			        				<ul>
				        				<li><?=anchor('/about/scientific',$this->lang->line('page_scientific_general'))?></li>
				        				<li><?=anchor('/about/scientific/publications',$this->lang->line('page_scientific_publications'))?></li>
				        				<li><?=anchor('/about/scientific/projects',$this->lang->line('page_scientific_projects'))?></li>
				        				<li><?=anchor('/about/scientific/directions',$this->lang->line('page_scientific_directions'))?></li>
				        			</ul>
		        				</li>
			        			<li><?=anchor('/about/international',$this->lang->line('page_international'))?></li>
			        		</ul>
		        		</li>
		        		<li><?=anchor('/about/staff',$this->lang->line('page_staff'))?></li>
		        		<li>
		        			<?=$this->lang->line('page_students')?>
		        			<ul>
		        				<li><?=anchor('/about/students/bachelor',$this->lang->line('page_bachelors'))?></li>
		        				<li><?=anchor('/about/students/master',$this->lang->line('page_masters'))?></li>
		        				<li><?=anchor('/about/students/pg',$this->lang->line('page_pgs'))?></li>
		        				<li><?=anchor('/about/students/doc',$this->lang->line('page_docs'))?></li>
		        			</ul>
		        		</li>
		        	</ul>
	        	</li>
	        	<li><?=anchor('/news', $this->lang->line('page_news'))?></li>
	        	<li><?=anchor('/conferences', $this->lang->line('page_conferences'))?></li>
	        	<li><?=anchor('/partners', $this->lang->line('page_partners'))?></li>
	        	<li><?=anchor('/contacts', $this->lang->line('page_contacts'))?></li>
	        </ul>
	    </li>
	</ul>
</div>