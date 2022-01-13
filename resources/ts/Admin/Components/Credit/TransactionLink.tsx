import * as React from 'react';
import { Component } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

interface GroupLinkProps {
	uuid: string,
}

export default function GroupLink( props: GroupLinkProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return(
		<div>
			<span>№ </span>
			<b>
				<span>{ props.uuid }</span>
			</b>
		</div>
	);
}
 

