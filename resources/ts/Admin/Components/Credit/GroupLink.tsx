import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';

import { 
	Button,
} from '@wordpress/components';

interface GroupLinkProps {
	uuid: string,
	name?: string,
	text?: boolean,
}

export default function GroupLink( props: GroupLinkProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	const title = props?.name ?? props.uuid;
	const url = `${ adminPageUrl }${ namespace }-credit-group-show&id=${ props.uuid }`;
	if ( props.text ) {
		return (
			<b><span>{ title }</span></b>
		)
	}
	return (
		<Button
			isLink	
			href={ url }
		>
			{ title }
		</Button>
	);
}
 

