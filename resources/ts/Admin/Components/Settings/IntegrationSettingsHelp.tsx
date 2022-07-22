import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import { 
	Button,
	Flex,
} from '@wordpress/components'

interface IntegrationSettingsHelpProps {
	appHomepageUrl: string
	clientAuthUrl: string
}

export default function IntegrationSettingsHelp( props: IntegrationSettingsHelpProps ) {
	const brand = useInjection( TYPES.Variables.brand )
	const apiHost = useInjection( TYPES.Variables.apiHost )

	function copyToClipboard( text: string ) {
		if ( navigator && navigator.clipboard ) {
			navigator.clipboard.writeText( text )
		}
	}

	return (
		<div>
			<ul className="tk_steps">
				<li>
					<span>1. Add a new application on </span>
					<a href={ `${apiHost}/auth/apps` } target="_blank">{ brand } Developers</a>.
				</li>
				<li>2. Enter the received app credentials below.</li>
				<li>3. Connect your { brand } account on the Connection screen to unlock more features.</li>
			</ul>
			<div className="tk_app_details">
				<h3>Register Client Application</h3>
				<Flex align="center" justify="flex-start" gap={1}>
					<span><b>Client Name: </b></span>
					<span>Random Input</span>
				</Flex>
				<Flex align="center" justify="flex-start" gap={1}>
					<span>
						<span><b>App Homepage URL: </b></span>
						<a href={ props?.appHomepageUrl } target="_blank" >
							{ props?.appHomepageUrl }
						</a>
					</span>
					<Button
						isSmall
						title="Copy Homepage URL"
						icon="admin-page"
						onClick={ () => {
							copyToClipboard( props?.appHomepageUrl )
						} }
					/>
				</Flex>
				<Flex align="center" justify="flex-start" gap={ 1 }>
					<span>
						<span><b>Client Authorization Redirect URL: </b></span>
						<a href={ props?.clientAuthUrl } target="_blank" >
							{ props?.clientAuthUrl }
						</a>
					</span>
					<Button
						isSmall
						title="Copy Redirect URL"
						icon="admin-page"
						onClick={ () => {
							copyToClipboard( props?.clientAuthUrl )
						} }
					/>
				</Flex>
			</div>
		</div>
	)
}
 

