<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="../utilities/master.xsl"/>
<xsl:import href="../utilities/login-panel.xsl"/>

<xsl:variable name="member" select="/data/events/member-login-info"/>

<xsl:template match="data">
	<xsl:choose>
		<xsl:when test="$member/@logged-in = 'true'">
			<h2>Members Area</h2>
			<h3>Welcome, <xsl:value-of select="$member/first-name"/></h3>
			<p>You have successfully logged in as a member of the
				<em><xsl:value-of select="$website-name"/></em> site. 
				Click here to <a href="?member-action=logout">logout</a>.</p>
			<hr/>
		</xsl:when>
		<xsl:otherwise>
			<h2>Members Only</h2>
			<h3>Login</h3>
			<p>If you have already registered as a member of the <em><xsl:value-of select="$website-name"/></em> site, please enter your login information here. If you are not yet a member, please <a href="{$root}/register/">register</a>.</p>
			<hr/>
			<xsl:choose>
				<xsl:when test="$action = 'forgot'">
					<h2>Retrieve Password</h2>
					<div id="guideline">
						<h4>Forgot Password?</h4>
						<ul>
							<li>If you have forgotten your password, you can retrieve it here.</li>
							<li>If you are already a member, <a href="{$root}/login/">login</a>.</li>
							<li>If you are not a member, <a href="{$root}/register/">register</a>.</li>
						</ul>
					</div>
					<form method="post" action="">
						<p class="help">Enter your email address below and you will be sent an email containing your password</p>
						<fieldset>
							<label>Email Address: <input name="member-email-address" type="text" /></label>
							<input type="submit" id="submit" name="action[member-retrieve-password]" value="Retrieve Password" />
							<p><a href="{$root}/login/">Cancel (back to login)</a></p>
						</fieldset>
					</form>
				</xsl:when>
				<xsl:otherwise>
					<xsl:call-template name="login-panel"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>
	
</xsl:stylesheet>