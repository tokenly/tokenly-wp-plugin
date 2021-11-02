import * as React from 'react';
import { Component } from 'react';
import { ConfirmModal } from '../admin/components/ConfirmModal';
import { ConfirmModalData } from '../Interfaces';
import eventBus from "../EventBus";

import { 
	Fragment,
} from '@wordpress/element';

interface AppLayoutProps {
	children: any;
}

interface AppLayoutState {
	confirmModalData: ConfirmModalData;
	confirmModalShow: boolean;
}

export default class AppLayout extends Component<AppLayoutProps, AppLayoutState> {
	state: AppLayoutState = {
		confirmModalData: null,
		confirmModalShow: false,
	};
	constructor( props: AppLayoutProps ) {
		super( props );
		this.onConfirmModalShow = this.onConfirmModalShow.bind( this );
		this.onConfirmModalRequestClose = this.onConfirmModalRequestClose.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
	}

	onConfirmModalRequestClose() {
		this.setState( {
			confirmModalData: null,
			confirmModalShow: false,
		} );
	}

	onConfirmModalChoice( choice: string ) {
		eventBus.dispatch( 'confirmModalChoice', {
			key: this.state?.confirmModalData?.key,
			choice: choice,
		} );
		this.onConfirmModalRequestClose();
	}

	onConfirmModalShow( confirmModalData: ConfirmModalData ) {
		this.setState( {
			confirmModalData: confirmModalData,
			confirmModalShow: true,
		} );
	}

	componentDidMount() {
		eventBus.on( 'confirmModalShow', this.onConfirmModalShow );
	}
	
	componentWillUnmount() {
		eventBus.remove( 'confirmModalShow', this.onConfirmModalShow );
	}

	render() {
		return (
			<Fragment>
				{ this.state.confirmModalShow == true &&
					<ConfirmModal
						key={ this.state.confirmModalData.key }
						title={ this.state.confirmModalData.title }
						subtitle={ this.state.confirmModalData.subtitle }
						onRequestClose={ this.onConfirmModalRequestClose }
						onChoice={ this.onConfirmModalChoice }
					/>
				}
				{ this.props.children }
			</Fragment>
		)
	}
}
