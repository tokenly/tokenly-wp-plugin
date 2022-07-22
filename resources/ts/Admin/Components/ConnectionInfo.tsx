import * as React from 'react'
import StatusIndicator from '../Components/StatusIndicator'
import UserInterface from '../../Interfaces/Models/UserInterface'

interface ConnectionInfoProps {
	status: boolean
	user: UserInterface
}

export default function ConnectionInfo( props: ConnectionInfoProps ) {
	return (
		<div>
			<StatusIndicator status={ props?.status } />
			{ props.status == true &&
				<div>
					<span>Connected As: </span>
					<span>
						<b>{`${ props.user?.name } ( ${ props.user?.oauthUser?.username } )` }</b>
					</span>
				</div>
			}
		</div>
	)
}
