import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
} from '@wordpress/components';

interface SourceCardProps {
	source: SourceItem;
}

interface SourceCardState {
	//
}

export class SourceCard extends Component<SourceCardProps, SourceCardState> {

	constructor( props: SourceCardProps ) {
		super( props );
		this.getAssets = this.getAssets.bind( this );
	}
	
	getAssets() {
		let assets = 'all';
		if ( this.props.source?.assets?.length ) {
			assets = this.props.source?.assets?.join( ', ' );
		}
		return assets;
	}

	render() {
		return (
			<Card size="extraSmall" style={ { width: '100%' } }>
				<CardHeader>
					<div title={ this.props.source.address }>
						<a 
							href={ `/wp-admin/admin.php?page=tokenpass-source-show&source=${ this.props.source.address }` }
						>
							{ this.props.source.address_data?.label }
						</a>
					</div>
				</CardHeader>
				<CardBody style={ { width: '100%' } }>
					<Flex style={ { width: '100%', alignItems: 'center' } }>
						<div style={ { flex: 1 } }>
							<div><span>Assets (whitelisted): </span><strong>{ this.getAssets() }</strong></div>
						</div>
					</Flex>
				</CardBody>
				<CardFooter>
					<Flex justify="flex-start">
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenpass-source-edit&source=${ this.props.source.address }` }
						>
							Manage source
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenpass-source-show&source=${ this.props.source.address }` }
						>
							View details
						</Button>
						<Button
							isSecondary
							isSmall
							href={ `/wp-admin/admin.php?page=tokenpass-balances-show&address=${ this.props.source.address }` }
						>
							View balances
						</Button>
					</Flex>
				</CardFooter>
			</Card>
		);
	}
}
 
