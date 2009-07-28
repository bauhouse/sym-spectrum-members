<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="registration-form">
	<form method="post" action="" enctype="multipart/form-data">

		<xsl:for-each select="/data/events/register-member">
			<p class="{@result}">
				<xsl:choose>
					<xsl:when test="@result = 'success'">Your registration was successful. Please <a href="{$root}/login/">login</a>.</xsl:when>
					<xsl:otherwise>The system encountered errors. Please check if all the required fields have been filled.</xsl:otherwise>
				</xsl:choose>
			</p>
			<xsl:if test="filter/@status = 'failed'">
				<p class="error">The system encountered errors while sending your email. <xsl:value-of select="filter"/></p>
			</xsl:if>
		</xsl:for-each>

		<fieldset>
			<input name="MAX_FILE_SIZE" type="hidden" value="5242880" />
			<label class="required">First Name
				<input name="fields[first-name]" type="text" />
			</label>
			<label class="required">Last Name
				<input name="fields[last-name]" type="text" />
			</label>
			<div class="group">
				<label class="required">Username
					<input name="fields[member][username]" type="text" />
				</label>
				<label class="required">Password
					<input name="fields[member][password]" type="password" />
				</label>
			</div>
			<input name="fields[role]" type="hidden" value="2"/>
			<label class="required">Email
				<input name="fields[email]" type="text" />
			</label>
	
			<input name="send-email[from]" value="{/data/website-owner/author/email}" type="hidden" />
			<input name="send-email[subject]" value="fields[subject]" type="hidden" />
			<input name="send-email[body]" value="fields[message]" type="hidden" />
			<input name="send-email[recipient]" value="{/data/website-owner/author/username}" type="hidden" />

			<input name="action[register-member]" type="submit" value="Register" />
		</fieldset>
	</form>
</xsl:template>

</xsl:stylesheet>