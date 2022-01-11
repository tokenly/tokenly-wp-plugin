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
	group: any;
}

interface GroupCardState {
	//
}

export default class GroupCard extends Component<GroupCardProps, GroupCardState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: GroupCardProps ) {
		super( props );
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<GroupLink name={ this.props.group?.name } uuid={ this.props.group?.uuid } />
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<GroupInfo group={ this.props.group } />
				</CardBody>
				<CardFooter>
					<CardActions
						actions={
							[
								{
									title: 'View transactions',
									url: `${ this.adminPageUrl }${ this.namespace }-credit-transaction-index&group=${ this.props.group.uuid }`,
								},
								{
									title: 'View details',
									url: `${ this.adminPageUrl }${ this.namespace }-credit-group-show&group=${ this.props.group.uuid }`,
								},
								{
									title: 'Edit group',
									url: `${ this.adminPageUrl }${ this.namespace }-credit-group-edit&group=${ this.props.group.uuid }`,
								},
							]
						}
					/>
				</CardFooter>
			</Card>
		);
	}
}
 

