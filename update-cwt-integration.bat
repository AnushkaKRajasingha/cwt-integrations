echo [%date%, %time%] >> "filemodlog.log"
xcopy "D:\Projects\attlee-realtor\carwashtraders.com\cwt-integrations\cwt-integrations\" "D:\Projects\carwashtraders.com\staging\wp-content\plugins\cwt-integrations" /D /E /C /H /R /Y /K >> "filemodlog.log"