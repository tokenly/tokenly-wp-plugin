import * as React from 'react';
import * as dayjs from 'dayjs'

import { 
	Flex,
} from '@wordpress/components';

interface GroupInfoProps {
	group: any;
	verbose?: boolean;
}

export default function GroupInfo( props: GroupInfoProps ) {
	function dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	return (
		<Flex style={ { width: '100%', alignItems: 'center' } }>
			<div style={ { flex: 1 } }>
			{ props.verbose &&
				<div>
					<div>
						<span>Name: </span>
						<b>{ props?.group?.name }</b>
					</div>
					<div>
						<span>UUID: </span>
						<b>{ props?.group?.uuid }</b>
					</div>
					<div>
						<span>App Whitelist: </span>
						<b>{ props?.group?.app_whitelist }</b>
					</div>
					<div>
						<span>Created At: </span>
						<b>{ dateFormatted( props?.group?.created_at ) }</b>
					</div>
					<div>
						<span>Updated At: </span>
						<b>{ dateFormatted( props?.group?.updated_at ) }</b>
					</div>
				</div>
			}
				<div>
					<span>Active: </span>
					<b>{ props?.group?.active ? 'Yes' : 'No' }</b>
				</div>
			</div>
		</Flex>
	);
}
