<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="login-panel">
	<h2>Login Form</h2>
	<div id="guideline">
		<h4>Notes</h4>
		<ul>
			<li>If you are not a member, please <a href="{$root}/register/">register</a>.</li>
			<li>If you have forgotten your password, you can <a href="{$root}/login/forgot/">retrieve it</a>.</li>
		</ul>
	</div>
	<form id="login-panel" action="" method="post">
		<xsl:if test="$member/@logged-in = 'true'">
			<p class="help">
				<a href=""><xsl:value-of select="$member/first-name"/></a>
				<xsl:text> </xsl:text>
				<a href="?member-action=logout">(Logout)</a>
			</p>
		</xsl:if>

		<fieldset>
			<label class="required">Username: 
				<input name="username" type="text" value="member"/>
			</label>
			<label class="required">Password: 
				<input name="password" type="password" value="123123"/>
			</label>
			<input id="submit" type="submit" name="member-action[login]" value="Log In"/>
			<input name="redirect" type="hidden" value="{$root}/members/" />
			<p><a href="{$root}/login/forgot/">Forgot your password?</a></p>
		</fieldset>
	</form>
</xsl:template>

</xsl:stylesheet>