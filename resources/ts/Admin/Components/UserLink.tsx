import * as React from 'react';

import { 
	 Dashicon,
} from '@wordpress/components';

interface UserLinkProps {
	url: string;
	alt: string;
	name: string;
}

export default function UserLink( props: UserLinkProps ) {
	return (
		<div>
			<Dashicon icon="admin-users" style={ { marginRight: '2px' } } />
			<b title={ props.alt }>
				<a href={ props.url } >
					<span>{ props.name ? props.name : 'Unknown' }</span>
				</a>
			</b>
		</div>
	);
}
 

