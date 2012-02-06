@ECHO OFF
ECHO Lower case block Name
set /p Lower=
ECHO Upper case block Name
set /p Upper=
md %Lower%
md %Lower%\assets
echo ; Block %Upper% >>%Lower%\info.ini
echo [block] >> %Lower%\info.ini
echo id=%Lower% >> %Lower%\info.ini
echo name = %Upper% Block >> %Lower%\info.ini
echo version = 1.0 >> %Lower%\info.ini
echo class= %Upper%Block >> %Lower%\info.ini
copy search\SearchBlock.php %Lower%\%Upper%Block.php
copy search\search_block_input.php %Lower%\%Lower%_block_input.php
echo. >>%Lower%\%Lower%_block_output.php
Pause
