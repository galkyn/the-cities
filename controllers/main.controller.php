<?php

class MainController
{
    public function DefaultPage()
    {
        
        include './templates/page.header.template.php';//���������� ������ � ����������� �����: �������, �����, ������ � �.�.
	
	include './templates/main.template.php';
	
	include './templates/page.footer.template.php';
        
    }
}

?>