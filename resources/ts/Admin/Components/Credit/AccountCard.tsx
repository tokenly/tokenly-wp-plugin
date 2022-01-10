import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';
import CardActions from './../CardActions';
import GroupInfo from './GroupInfo';
import GroupLink from './GroupLink';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter
} from '@wordpress/components';

interface GroupCardProps {
	account: any;
}

interface GroupCardState {
	//
}

export default class GroupCard extends Component<GroupCardProps, GroupCardState> {
	@resolve( TYPES.Variables.adminUrl )
	adminUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: GroupCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<span>{ this.props?.account?.name }</span>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
				</CardBody>
			</Card>
		);
	}
}
 

